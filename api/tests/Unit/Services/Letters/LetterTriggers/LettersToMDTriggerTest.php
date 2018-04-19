<?php

namespace Tests\Unit\Services\Letters\LetterTriggers;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Services\Letters\LetterTriggers\LettersToMDTrigger;
use DentalSleepSolutions\Services\Emails\MailerDataRetriever;
use DentalSleepSolutions\Structs\LetterData;
use DentalSleepSolutions\Structs\MDContacts;
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
        $letterRepository = $this->mockLetterRepository();
        $userRepository = $this->mockUserRepository();
        $contactRepository = $this->mockContactRepository();
        $this->lettersToMDTrigger = new LettersToMDTrigger(
            $letterCreator, $letterRepository, $userRepository, $contactRepository
        );
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testOneLetterSent()
    {
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $userType = 4;
        $mdContacts = new MDContacts();
        $mdContacts->docdentist = 0;
        $mdContacts->docent = 1;
        $mdContacts->docmdother = 2;
        $mdContacts->docmdother2 = 3;
        $params = [LettersToMDTrigger::MD_CONTACTS_PARAM => $mdContacts];
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

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testTwoLettersSent()
    {
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $userType = MailerDataRetriever::DSS_USER_TYPE_SOFTWARE;
        $mdContacts = new MDContacts();
        $mdContacts->docdentist = 0;
        $mdContacts->docent = 1;
        $mdContacts->docmdother = 2;
        $mdContacts->docmdother2 = 3;
        $params = [LettersToMDTrigger::MD_CONTACTS_PARAM => $mdContacts];
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

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testWithoutLetterInfo()
    {
        $patientId = 1;
        $docId = 1;
        $userId = 3;
        $userType = 4;
        $mdContacts = new MDContacts();
        $mdContacts->docent = 1;
        $mdContacts->docmdother = 2;
        $params = [LettersToMDTrigger::MD_CONTACTS_PARAM => $mdContacts];
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);
        $this->assertEquals([], $this->createdLetters);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testWithoutUseLetters()
    {
        $this->users[0]->use_letters = false;
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $userType = 4;
        $mdContacts = new MDContacts();
        $mdContacts->docent = 1;
        $mdContacts->docmdother = 2;
        $params = [LettersToMDTrigger::MD_CONTACTS_PARAM => $mdContacts];
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);
        $this->assertEquals([], $this->createdLetters);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testWithoutIntroLetters()
    {
        $this->users[0]->intro_letters = false;
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $userType = 4;
        $mdContacts = new MDContacts();
        $mdContacts->docent = 1;
        $mdContacts->docmdother = 2;
        $params = [LettersToMDTrigger::MD_CONTACTS_PARAM => $mdContacts];
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);
        $this->assertEquals([], $this->createdLetters);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testWithoutRecipients()
    {
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $userType = 4;
        $mdContacts = new MDContacts();
        $mdContacts->docent = 3;
        $mdContacts->docmdother = 4;
        $params = [LettersToMDTrigger::MD_CONTACTS_PARAM => $mdContacts];
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);
        $this->assertEquals([], $this->createdLetters);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testWithoutMdContacts()
    {
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage(LettersToMDTrigger::MD_CONTACTS_PARAM . ' key must be present in $params and contain an instance of ' . MDContacts::class);
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testWithMalformedMdContacts()
    {
        $patientId = 1;
        $docId = 2;
        $userId = 3;
        $userType = 4;
        $params = [LettersToMDTrigger::MD_CONTACTS_PARAM => 'foo'];
        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage(LettersToMDTrigger::MD_CONTACTS_PARAM . ' key must be present in $params and contain an instance of ' . MDContacts::class);
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);
    }

    private function mockUserRepository()
    {
        /** @var UserRepository|MockInterface $userRepository */
        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getWithFilter')
            ->andReturnUsing([$this, 'getUserWithFilterCallback']);
        return $userRepository;
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
