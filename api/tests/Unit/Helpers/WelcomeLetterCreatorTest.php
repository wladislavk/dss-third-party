<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\ContactType;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactTypeRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Helpers\LetterComposer;
use DentalSleepSolutions\Helpers\WelcomeLetterCreator;
use DentalSleepSolutions\Http\Controllers\LettersController;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class WelcomeLetterCreatorTest extends UnitTestCase
{
    /** @var User|null */
    private $letterInfo;

    /** @var ContactType|null */
    private $contactType;

    /** @var array[] */
    private $createdLetters = [];

    /** @var WelcomeLetterCreator */
    private $welcomeLetterCreator;

    public function setUp()
    {
        $this->letterInfo = new User();
        $this->letterInfo->use_letters = true;
        $this->letterInfo->intro_letters = true;
        $this->contactType = new ContactType();
        $this->contactType->physician = WelcomeLetterCreator::PHYSICIAN_ONE;

        $letterComposer = $this->mockLetterComposer();
        $userRepository = $this->mockUserRepository();
        $contactTypeRepository = $this->mockContactTypeRepository();
        $letterRepository = $this->mockLetterRepository();
        $this->welcomeLetterCreator = new WelcomeLetterCreator(
            $letterComposer, $userRepository, $contactTypeRepository, $letterRepository
        );
    }

    public function testCreateWelcomeLetter()
    {
        $docId = 1;
        $templateId = 2;
        $contactTypeId = 3;
        $userType = 99;
        $response = $this->welcomeLetterCreator->createWelcomeLetter($docId, $templateId, $contactTypeId, $userType);
        $this->assertEquals(['message' => WelcomeLetterCreator::SUCCESS_MESSAGE], $response);
        $expectedLetters = [
            [
                'docId' => WelcomeLetterCreator::DOC_ONE,
                'templateId' => 2,
                'mdList' => 1,
            ],
            [
                'docId' => WelcomeLetterCreator::DOC_TWO,
                'templateId' => 2,
                'mdList' => 1,
            ],
        ];
        $this->assertEquals($expectedLetters, $this->createdLetters);
    }

    public function testWithUserTypeSoftware()
    {
        $docId = 1;
        $templateId = 2;
        $contactTypeId = 3;
        $userType = LettersController::DSS_USER_TYPE_SOFTWARE;
        $response = $this->welcomeLetterCreator->createWelcomeLetter($docId, $templateId, $contactTypeId, $userType);
        $this->assertEquals(['message' => WelcomeLetterCreator::SUCCESS_MESSAGE], $response);
        $expectedLetters = [
            [
                'docId' => WelcomeLetterCreator::DOC_TWO,
                'templateId' => 2,
                'mdList' => 1,
            ],
        ];
        $this->assertEquals($expectedLetters, $this->createdLetters);
    }

    public function testWithoutLetterInfo()
    {
        $this->letterInfo = null;

        $docId = 1;
        $templateId = 2;
        $contactTypeId = 3;
        $userType = 99;
        $response = $this->welcomeLetterCreator->createWelcomeLetter($docId, $templateId, $contactTypeId, $userType);
        $this->assertEquals([], $response);
        $this->assertEquals([], $this->createdLetters);
    }

    public function testWithoutUseLetters()
    {
        $this->letterInfo->use_letters = false;

        $docId = 1;
        $templateId = 2;
        $contactTypeId = 3;
        $userType = 99;
        $response = $this->welcomeLetterCreator->createWelcomeLetter($docId, $templateId, $contactTypeId, $userType);
        $this->assertEquals([], $response);
        $this->assertEquals([], $this->createdLetters);
    }

    public function testWithoutIntroLetters()
    {
        $this->letterInfo->intro_letters = false;

        $docId = 1;
        $templateId = 2;
        $contactTypeId = 3;
        $userType = 99;
        $response = $this->welcomeLetterCreator->createWelcomeLetter($docId, $templateId, $contactTypeId, $userType);
        $this->assertEquals([], $response);
        $this->assertEquals([], $this->createdLetters);
    }

    public function testWithoutContactType()
    {
        $this->contactType = null;

        $docId = 1;
        $templateId = 2;
        $contactTypeId = 3;
        $userType = 99;
        $response = $this->welcomeLetterCreator->createWelcomeLetter($docId, $templateId, $contactTypeId, $userType);
        $this->assertEquals([], $response);
        $this->assertEquals([], $this->createdLetters);
    }

    public function testWithBadPhysician()
    {
        $this->contactType->physician = 99;

        $docId = 1;
        $templateId = 2;
        $contactTypeId = 3;
        $userType = 99;
        $response = $this->welcomeLetterCreator->createWelcomeLetter($docId, $templateId, $contactTypeId, $userType);
        $this->assertEquals([], $response);
        $this->assertEquals([], $this->createdLetters);
    }

    private function mockLetterComposer()
    {
        /** @var LetterComposer|MockInterface $letterComposer */
        $letterComposer = \Mockery::mock(LetterComposer::class);
        $letterComposer->shouldReceive('composeWelcomeLetter')
            ->andReturnUsing(function ($docId, $templateId, $mdList) {
                return [
                    'docId' => $docId,
                    'templateId' => $templateId,
                    'mdList' => $mdList,
                ];
            });
        return $letterComposer;
    }

    private function mockUserRepository()
    {
        /** @var UserRepository|MockInterface $userRepository */
        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getLetterInfo')
            ->andReturnUsing(function () {
                return $this->letterInfo;
            });
        return $userRepository;
    }

    private function mockContactTypeRepository()
    {
        /** @var ContactTypeRepository|MockInterface $contactTypeRepository */
        $contactTypeRepository = \Mockery::mock(ContactTypeRepository::class);
        $contactTypeRepository->shouldReceive('find')
            ->andReturnUsing(function () {
                return $this->contactType;
            });
        return $contactTypeRepository;
    }

    private function mockLetterRepository()
    {
        /** @var LetterRepository|MockInterface $letterRepository */
        $letterRepository = \Mockery::mock(LetterRepository::class);
        $letterRepository->shouldReceive('create')
            ->andReturnUsing(function (array $data) {
                $this->createdLetters[] = $data;
            });
        return $letterRepository;
    }
}
