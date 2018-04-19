<?php

namespace Tests\Unit\Services\Letters;

use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Services\Letters\LetterComposer;
use DentalSleepSolutions\Services\Letters\LetterCreationEvaluator;
use DentalSleepSolutions\Services\Letters\LetterCreator;
use DentalSleepSolutions\Structs\LetterData;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class LetterCreatorTest extends UnitTestCase
{
    /** @var bool */
    private $shouldBeCreated = true;

    /** @var bool */
    private $shouldEloquentCreate = true;

    /** @var LetterCreator */
    private $letterCreator;

    public function setUp()
    {
        $letterCreationEvaluator = $this->mockLetterCreationEvaluator();
        $letterComposer = $this->mockLetterComposer();
        $letterRepository = $this->mockLetterRepository();
        $userRepository = $this->mockUserRepository();
        $this->letterCreator = new LetterCreator(
            $letterCreationEvaluator, $letterComposer, $letterRepository, $userRepository
        );
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testCreateLetterWithoutReferralSource()
    {
        $letterData = new LetterData();
        $letterData->mdList = '1,2,3';
        $letterData->mdReferralList = '4,5,6';
        $templateId = 1;
        $docId = 2;
        $userId = 3;
        $letterId = $this->letterCreator->createLetter($templateId, $letterData, $docId, $userId);
        $this->assertEquals(10, $letterId);
        $this->assertEquals('1,2,3', $letterData->mdList);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testCreateLetterWithReferralSourceRemoved()
    {
        $letterData = new LetterData();
        $letterData->mdList = '1,2,3';
        $letterData->mdReferralList = '2';
        $templateId = 1;
        $docId = 2;
        $userId = 3;
        $letterId = $this->letterCreator->createLetter($templateId, $letterData, $docId, $userId);
        $this->assertEquals(10, $letterId);
        $this->assertEquals('1,3', $letterData->mdList);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testIfLetterShouldNotBeCreated()
    {
        $this->shouldBeCreated = false;
        $letterData = new LetterData();
        $templateId = 1;
        $docId = 2;
        $userId = 3;
        $letterId = $this->letterCreator->createLetter($templateId, $letterData, $docId, $userId);
        $this->assertEquals(0, $letterId);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testWithFailedCheckUseLetters()
    {
        $letterData = new LetterData();
        $templateId = 1;
        $docId = 1;
        $userId = 3;
        $letterId = $this->letterCreator->createLetter($templateId, $letterData, $docId, $userId);
        $this->assertEquals(0, $letterId);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testWithLetterNotCreatedByEloquent()
    {
        $this->shouldEloquentCreate = false;
        $letterData = new LetterData();
        $templateId = 1;
        $docId = 2;
        $userId = 3;
        $letterId = $this->letterCreator->createLetter($templateId, $letterData, $docId, $userId);
        $this->assertEquals(0, $letterId);
    }

    private function mockLetterCreationEvaluator()
    {
        /** @var LetterCreationEvaluator|MockInterface $letterCreationEvaluator */
        $letterCreationEvaluator = \Mockery::mock(LetterCreationEvaluator::class);
        $letterCreationEvaluator->shouldReceive('shouldLetterBeCreated')
            ->andReturnUsing(function () {
                return $this->shouldBeCreated;
            });
        return $letterCreationEvaluator;
    }

    private function mockLetterComposer()
    {
        /** @var LetterComposer|MockInterface $letterComposer */
        $letterComposer = \Mockery::mock(LetterComposer::class);
        $letterComposer->shouldReceive('composeLetter')
            ->andReturnUsing(function () {
                return [];
            });
        return $letterComposer;
    }

    private function mockUserRepository()
    {
        /** @var UserRepository|MockInterface $userRepository */
        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getWithFilter')
            ->andReturnUsing([$this, 'getUserWithFilterCallback']);
        return $userRepository;
    }

    private function mockLetterRepository()
    {
        /** @var LetterRepository|MockInterface $letterRepository */
        $letterRepository = \Mockery::mock(LetterRepository::class);
        $letterRepository->shouldReceive('create')
            ->andReturnUsing([$this, 'createLetterCallback']);
        return $letterRepository;
    }

    public function getUserWithFilterCallback(array $fields, array $where)
    {
        $user1 = new User();
        $user1->use_letters = false;
        $user2 = new User();
        $user2->use_letters = true;
        if ($where['userid'] == 1) {
            return [$user1, $user2];
        }
        return [$user2, $user1];
    }

    public function createLetterCallback()
    {
        if ($this->shouldEloquentCreate) {
            $letter = new Letter();
            $letter->letterid = 10;
            return $letter;
        }
        return null;
    }
}
