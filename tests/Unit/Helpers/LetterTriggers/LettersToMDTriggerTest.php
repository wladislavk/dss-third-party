<?php

namespace Tests\Unit\Helpers\LetterTriggers;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Helpers\LetterTriggers\LettersToMDTrigger;
use DentalSleepSolutions\Helpers\MailerDataRetriever;
use DentalSleepSolutions\Structs\LetterData;
use Mockery\MockInterface;
use Tests\TestCases\LetterTriggerTestCase;

class LettersToMDTriggerTest extends LetterTriggerTestCase
{
    /** @var User[] */
    private $users = [];

    /** @var LettersToMDTrigger */
    private $lettersToMDTrigger;

    public function setUp()
    {
        $user1 = new User();
        $user1->use_letters = true;
        $user1->intro_letters = true;
        $user2 = new User();
        $user2->use_letters = true;
        $user2->intro_letters = true;
        $this->users = [$user1, $user2];

        $letterCreator = $this->mockLetterCreator();
        $letterModel = $this->mockLetterModel();
        $userModel = $this->mockUserModel();
        $contactRepository = $this->mockContactRepository();
        $this->lettersToMDTrigger = new LettersToMDTrigger(
            $letterCreator, $letterModel, $userModel, $contactRepository
        );
    }

    public function testOneLetterSent()
    {
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $userType = 4;
        $params = [LettersToMDTrigger::MD_CONTACTS_PARAM => [0, 1, 2, 3]];
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);
        $expectedLetterData = new LetterData();
        $expectedLetterData->patientId = 1;
        $expectedLetterData->mdList = '1,2';
        $expectedCreatedLetters = [
            [
                'templateId' => LettersToMDTrigger::LETTER_TO_MD_FROM_FRANCHISEE,
                'letterData' => $expectedLetterData,
                'docId' => 2,
                'userId' => 3,
            ],
        ];
        $this->assertEquals($expectedCreatedLetters, $this->createdLetters);
    }

    public function testTwoLettersSent()
    {
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $userType = MailerDataRetriever::DSS_USER_TYPE_SOFTWARE;
        $params = [LettersToMDTrigger::MD_CONTACTS_PARAM => [0, 1, 2, 3]];
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);
        $expectedLetterData = new LetterData();
        $expectedLetterData->patientId = 1;
        $expectedLetterData->mdList = '1,2';
        $expectedCreatedLetters = [
            [
                'templateId' => LettersToMDTrigger::LETTER_TO_MD_FROM_FRANCHISEE,
                'letterData' => $expectedLetterData,
                'docId' => 2,
                'userId' => 3,
            ],
            [
                'templateId' => LettersToMDTrigger::LETTER_TO_MD_FROM_DSS,
                'letterData' => $expectedLetterData,
                'docId' => 2,
                'userId' => 3,
            ],
        ];
        $this->assertEquals($expectedCreatedLetters, $this->createdLetters);
    }

    public function testWithoutLetterInfo()
    {
        $patientId = 1;
        $docId = 1;
        $userId = 3;
        $userType = 4;
        $params = [LettersToMDTrigger::MD_CONTACTS_PARAM => [1, 2]];
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);
        $this->assertEquals([], $this->createdLetters);
    }

    public function testWithoutUseLetters()
    {
        $this->users[0]->use_letters = false;
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $userType = 4;
        $params = [LettersToMDTrigger::MD_CONTACTS_PARAM => [1, 2]];
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);
        $this->assertEquals([], $this->createdLetters);
    }

    public function testWithoutIntroLetters()
    {
        $this->users[0]->intro_letters = false;
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $userType = 4;
        $params = [LettersToMDTrigger::MD_CONTACTS_PARAM => [1, 2]];
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);
        $this->assertEquals([], $this->createdLetters);
    }

    public function testWithoutRecipients()
    {
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $userType = 4;
        $params = [LettersToMDTrigger::MD_CONTACTS_PARAM => [3, 4]];
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);
        $this->assertEquals([], $this->createdLetters);
    }

    public function testWithoutMdContacts()
    {
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage(LettersToMDTrigger::MD_CONTACTS_PARAM . ' key must be present in $params and contain an array');
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId);
    }

    public function testWithMalformedMdContacts()
    {
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $userType = 4;
        $params = [LettersToMDTrigger::MD_CONTACTS_PARAM => 'foo'];
        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage(LettersToMDTrigger::MD_CONTACTS_PARAM . ' key must be present in $params and contain an array');
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);
    }

    private function mockUserModel()
    {
        /** @var User|MockInterface $userModel */
        $userModel = \Mockery::mock(User::class);
        $userModel->shouldReceive('getWithFilter')
            ->andReturnUsing([$this, 'getUserWithFilterCallback']);
        return $userModel;
    }

    private function mockContactRepository()
    {
        /** @var ContactRepository|MockInterface $contactRepository */
        $contactRepository = \Mockery::mock(ContactRepository::class);
        $contactRepository->shouldReceive('getActiveContact')
            ->andReturnUsing([$this, 'getActiveContactCallback']);
        return $contactRepository;
    }

    public function getUserWithFilterCallback(array $fields, array $where)
    {
        if ($where['userid'] == 2) {
            return $this->users;
        }
        return null;
    }

    public function getActiveContactCallback($contactId)
    {
        $contact = new Contact();
        $contact->contactid = $contactId;
        return $contact;
    }
}
