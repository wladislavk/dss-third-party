<?php

namespace Tests\Unit\Helpers;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Eloquent\Repositories\Dental\FaxRepository;
use DentalSleepSolutions\Factories\LetterUpdaterFactory;
use DentalSleepSolutions\Helpers\GeneralHelper;
use DentalSleepSolutions\Helpers\LetterCreator;
use DentalSleepSolutions\Helpers\LetterDeleter;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Helpers\LetterUpdaters\PatientUpdater;
use DentalSleepSolutions\Helpers\QueryComposers\LettersQueryComposer;
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

    /**
     * @throws \DentalSleepSolutions\Exceptions\GeneralException
     */
    public function setUp()
    {
        $this->letter = new Letter();
        $this->letter->letterid = 1;
        $this->letter->patientid = 5;
        $this->letter->info_id = 6;
        $this->letter->templateid = 7;
        $this->letter->send_method = 'get';
        $this->letter->topatient = false;
        $this->letter->md_list = '';
        $this->letter->md_referral_list = '';
        $this->contactData = new ContactData();
        $this->contactData->setPatients([new Patient(), new Patient()]);

        $generalHelper = $this->mockGeneralHelper();
        $letterCreator = $this->mockLetterCreator();
        $lettersQueryComposer = $this->mockLettersQueryComposer();
        $letterUpdaterFactory = $this->mockLetterUpdaterFactory();
        $faxRepository = $this->mockFaxRepository();
        $this->letterDeleter = new LetterDeleter(
            $generalHelper,
            $letterCreator,
            $lettersQueryComposer,
            $letterUpdaterFactory,
            $faxRepository
        );
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\GeneralException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testWithSingleContact()
    {
        $this->contactData->setPatients([new Patient()]);
        $letter = new Letter();
        $letter->letterid = 1;
        $letter->md_list = '';
        $letter->md_referral_list = '';
        $type = 'foo';
        $recipientId = 2;
        $docId = 3;
        $userId = 4;
        $this->letterDeleter->deleteLetter($letter, $type, $recipientId, $docId, $userId);
        $this->assertEquals([], $this->createdLetter);
        $expectedFirstData = new LetterData();
        $expectedFirstData->deleted = true;
        $expectedFirstData->deletedBy = 4;
        $expectedFirstData->deletedOn = $this->updatedLetters[0]['updateArray']['deleted_on'];
        unset($this->updatedLetters[0]['updateArray']['deleted_on']);
        $expectedLetters = [
            [
                'where' => ['letterid' => 1],
                'updateArray' => [
                    'deleted' => true,
                    'deleted_by' => 4,
                ],
            ],
            [
                'where' => ['parentid' => 1],
                'updateArray' => [
                ],
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

    /**
     * @throws \DentalSleepSolutions\Exceptions\GeneralException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testWithSingleContactAndPatientId()
    {
        $this->letter->topatient = true;
        $this->contactData->setPatients([new Patient()]);
        $type = 'foo';
        $recipientId = 2;
        $docId = 3;
        $userId = 4;
        $this->letterDeleter->deleteLetter($this->letter, $type, $recipientId, $docId, $userId);
        $this->assertEquals(5, $this->patientId);
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\GeneralException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testWithMultipleContacts()
    {
        $type = 'foo';
        $recipientId = 2;
        $docId = 3;
        $userId = 4;
        $template = 'my_letter';
        $this->letterDeleter->deleteLetter($this->letter, $type, $recipientId, $docId, $userId, $template);

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

    /**
     * @throws \DentalSleepSolutions\Exceptions\GeneralException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testWithMultipleContactsAndNewLetterId()
    {
        $this->shouldCreateLetter = true;
        $type = 'foo';
        $recipientId = 2;
        $docId = 3;
        $userId = 4;
        $template = 'my_letter';
        $this->letterDeleter->deleteLetter($this->letter, $type, $recipientId, $docId, $userId, $template);
        $expectedUpdatedLetters = [
            [
                'where' => ['letterid' => 1],
                'updateArray' => [

                ],
            ],
        ];
        $this->assertEquals($expectedUpdatedLetters, $this->updatedLetters);
    }

    private function mockGeneralHelper()
    {
        /** @var GeneralHelper|MockInterface $generalHelper */
        $generalHelper = \Mockery::mock(GeneralHelper::class);
        $generalHelper->shouldReceive('getContactInfo')->andReturnUsing(function ($patientId) {
            $this->patientId = $patientId;
            return $this->contactData;
        });
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

    private function mockFaxRepository()
    {
        /** @var FaxRepository|MockInterface $faxRepository */
        $faxRepository = \Mockery::mock(FaxRepository::class);
        $faxRepository->shouldReceive('updateByLetterId')
            ->andReturnUsing([$this, 'updateFaxByLetterIdCallback']);
        return $faxRepository;
    }

    private function mockPatientUpdater()
    {
        /** @var PatientUpdater|MockInterface $patientUpdater */
        $patientUpdater = \Mockery::mock(PatientUpdater::class);
        $patientUpdater->shouldReceive('updateDataBeforeDeleting')
            ->andReturnUsing([$this, 'updateDataBeforeDeletingCallback']);
        $patientUpdater->shouldReceive('getUpdatedFields')
            ->andReturnUsing(function () {
                return ['foo', 'bar'];
            });
        return $patientUpdater;
    }

    private function mockLettersQueryComposer()
    {
        /** @var LettersQueryComposer|MockInterface $lettersQueryComposer */
        $lettersQueryComposer = \Mockery::mock(LettersQueryComposer::class);
        $lettersQueryComposer->shouldReceive('updateLetterBy')
            ->andReturnUsing([$this, 'updateLetterByCallback']);
        return $lettersQueryComposer;
    }

    public function findLetterCallback($letterId)
    {
        if ($letterId == $this->letter->letterid) {
            return $this->letter;
        }
        return null;
    }

    public function updateLetterByCallback(array $where, array $updateArray)
    {
        $this->updatedLetters[] = [
            'where' => $where,
            'updateArray' => $updateArray,
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
}
