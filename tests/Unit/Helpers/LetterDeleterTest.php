<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Fax;
use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Factories\LetterUpdaterFactory;
use DentalSleepSolutions\Helpers\GeneralHelper;
use DentalSleepSolutions\Helpers\LetterCreator;
use DentalSleepSolutions\Helpers\LetterDeleter;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Helpers\LetterUpdaters\PatientUpdater;
use DentalSleepSolutions\Structs\ContactData;
use DentalSleepSolutions\Structs\LetterData;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class LetterDeleterTest extends UnitTestCase
{
    /** @var Letter */
    private $letter;

    /** @var array */
    private $createdLetter = [];

    /** @var array */
    private $updatedLetters = [];

    /** @var array */
    private $updatedFax = [];

    /** @var int */
    private $patientId;

    /** @var ContactData */
    private $contactData;

    /** @var bool */
    private $shouldCreateLetter = false;

    /** @var LetterDeleter */
    private $letterDeleter;

    public function setUp()
    {
        date_default_timezone_set('UTC');

        $this->letter = new Letter();
        $this->letter->letterid = 1;
        $this->letter->patientid = 5;
        $this->letter->info_id = 6;
        $this->letter->templateid = 7;
        $this->letter->send_method = 'get';
        $this->letter->topatient = false;
        $this->contactData = new ContactData();
        $this->contactData->setPatients([new Patient(), new Patient()]);

        $generalHelper = $this->mockGeneralHelper();
        $letterCreator = $this->mockLetterCreator();
        $letterUpdaterFactory = $this->mockLetterUpdaterFactory();
        $letterModel = $this->mockLetterModel();
        $faxModel = $this->mockFaxModel();
        $this->letterDeleter = new LetterDeleter(
            $generalHelper, $letterCreator, $letterUpdaterFactory, $letterModel, $faxModel
        );
    }

    public function testWithSingleContact()
    {
        $this->contactData->setPatients([new Patient()]);
        $letterId = 1;
        $type = 'foo';
        $recipientId = 2;
        $docId = 3;
        $userId = 4;
        $this->letterDeleter->deleteLetter($letterId, $type, $recipientId, $docId, $userId);
        $this->assertEquals([], $this->createdLetter);
        $expectedFirstData = new LetterData();
        $expectedFirstData->deleted = true;
        $expectedFirstData->deletedBy = 4;
        $expectedFirstData->deletedOn = $this->updatedLetters[0]['data']->deletedOn;
        $expectedLetters = [
            [
                'where' => ['letterid' => 1],
                'data' => $expectedFirstData,
                'fields' => ['parentid', 'deleted', 'deleted_by', 'deleted_on'],
            ],
            [
                'where' => ['parentid' => 1],
                'data' => new LetterData(),
                'fields' => ['parentid'],
            ],
        ];
        $this->assertEquals($expectedLetters, $this->updatedLetters);
        $expectedFax = [
            'letterId' => 1,
            'data' => ['viewed' => 1],
        ];
        $this->assertEquals($expectedFax, $this->updatedFax);
        $this->assertEquals(0, $this->patientId);
    }

    public function testWithSingleContactAndPatientId()
    {
        $this->letter->topatient = true;
        $this->contactData->setPatients([new Patient()]);
        $letterId = 1;
        $type = 'foo';
        $recipientId = 2;
        $docId = 3;
        $userId = 4;
        $this->letterDeleter->deleteLetter($letterId, $type, $recipientId, $docId, $userId);
        $this->assertEquals(5, $this->patientId);
    }

    public function testWithMultipleContacts()
    {
        $letterId = 1;
        $type = 'foo';
        $recipientId = 2;
        $docId = 3;
        $userId = 4;
        $template = 'my_letter';
        $this->letterDeleter->deleteLetter($letterId, $type, $recipientId, $docId, $userId, $template);

        $expectedLetterData = new LetterData();
        $expectedLetterData->patientId = 5;
        $expectedLetterData->infoId = 6;
        $expectedLetterData->parentId = 1;
        $expectedLetterData->template = 'my_letter';
        $expectedLetterData->sendMethod = 'get';
        $expectedLetterData->status = false;
        $expectedLetterData->deleted = true;
        $expectedLetterData->checkRecipient = false;
        $expectedLetterData->patientReferralList = '1,2';
        $expectedCreatedLetter = [
            'templateId' => 7,
            'docId' => 3,
            'userId' => 4,
            'data' => $expectedLetterData,
        ];
        $this->assertEquals($expectedCreatedLetter, $this->createdLetter);
        $this->assertEquals([], $this->updatedLetters);
        $this->assertEquals([], $this->updatedFax);
    }

    public function testWithMultipleContactsAndNewLetterId()
    {
        $this->shouldCreateLetter = true;
        $letterId = 1;
        $type = 'foo';
        $recipientId = 2;
        $docId = 3;
        $userId = 4;
        $template = 'my_letter';
        $this->letterDeleter->deleteLetter($letterId, $type, $recipientId, $docId, $userId, $template);
        $expectedUpdatedData = new LetterData();
        $expectedUpdatedData->patientReferralList = '3,4';
        $expectedUpdatedLetters = [
            [
                'where' => ['letterid' => 1],
                'data' => $expectedUpdatedData,
                'fields' => ['foo', 'bar'],
            ],
        ];
        $this->assertEquals($expectedUpdatedLetters, $this->updatedLetters);
    }

    public function testWithoutLetter()
    {
        $letterId = 2;
        $type = 'foo';
        $recipientId = 2;
        $docId = 3;
        $userId = 4;
        $this->letterDeleter->deleteLetter($letterId, $type, $recipientId, $docId, $userId);
        $this->assertEquals([], $this->createdLetter);
        $this->assertEquals([], $this->updatedLetters);
        $this->assertEquals([], $this->updatedFax);
    }

    private function mockGeneralHelper()
    {
        /** @var GeneralHelper|MockInterface $generalHelper */
        $generalHelper = \Mockery::mock(GeneralHelper::class);
        $generalHelper->shouldReceive('getContactInfo')
            ->andReturnUsing([$this, 'getContactInfoCallback']);
        return $generalHelper;
    }

    private function mockLetterCreator()
    {
        /** @var LetterCreator|MockInterface $letterCreator */
        $letterCreator = \Mockery::mock(LetterCreator::class);
        $letterCreator->shouldReceive('createLetter')
            ->andReturnUsing([$this, 'createLetterCallback']);
        return $letterCreator;
    }

    private function mockLetterUpdaterFactory()
    {
        /** @var LetterUpdaterFactory|MockInterface $letterUpdaterFactory */
        $letterUpdaterFactory = \Mockery::mock(LetterUpdaterFactory::class);
        $letterUpdaterFactory->shouldReceive('getLetterUpdater')
            ->andReturn($this->mockPatientUpdater());
        return $letterUpdaterFactory;
    }

    private function mockLetterModel()
    {
        /** @var Letter|MockInterface $letterModel */
        $letterModel = \Mockery::mock(Letter::class);
        $letterModel->shouldReceive('find')->andReturnUsing([$this, 'findLetterCallback']);
        $letterModel->shouldReceive('updateLetterBy')
            ->andReturnUsing([$this, 'updateLetterByCallback']);
        return $letterModel;
    }

    private function mockFaxModel()
    {
        /** @var Fax|MockInterface $faxModel */
        $faxModel = \Mockery::mock(Fax::class);
        $faxModel->shouldReceive('updateByLetterId')
            ->andReturnUsing([$this, 'updateFaxByLetterIdCallback']);
        return $faxModel;
    }

    private function mockPatientUpdater()
    {
        /** @var PatientUpdater|MockInterface $patientUpdater */
        $patientUpdater = \Mockery::mock(PatientUpdater::class);
        $patientUpdater->shouldReceive('updateDataBeforeDeleting')
            ->andReturnUsing([$this, 'updateDataBeforeDeletingCallback']);
        $patientUpdater->shouldReceive('getUpdatedFields')
            ->andReturnUsing([$this, 'getUpdatedFieldsCallback']);
        return $patientUpdater;
    }

    public function findLetterCallback($letterId)
    {
        if ($letterId == $this->letter->letterid) {
            return $this->letter;
        }
        return null;
    }

    public function getContactInfoCallback($patientId)
    {
        $this->patientId = $patientId;
        return $this->contactData;
    }

    public function updateLetterByCallback(array $where, LetterData $data, array $fields)
    {
        $this->updatedLetters[] = [
            'where' => $where,
            'data' => $data,
            'fields' => $fields,
        ];
    }

    public function updateFaxByLetterIdCallback($letterId, array $data)
    {
        $this->updatedFax = [
            'letterId' => $letterId,
            'data' => $data,
        ];
    }

    public function createLetterCallback($templateId, LetterData $letterData, $docId, $userId)
    {
        $this->createdLetter = [
            'templateId' => $templateId,
            'docId' => $docId,
            'userId' => $userId,
            'data' => $letterData,
        ];
        $letterId = 0;
        if ($this->shouldCreateLetter) {
            $letterId = 15;
        }
        return $letterId;
    }

    public function updateDataBeforeDeletingCallback(
        Letter $letter,
        $recipientId,
        LetterData $newLetterData,
        LetterData $dataForUpdate
    ) {
        $newLetterData->patientReferralList = '1,2';
        $dataForUpdate->patientReferralList = '3,4';
    }

    public function getUpdatedFieldsCallback()
    {
        return ['foo', 'bar'];
    }
}
