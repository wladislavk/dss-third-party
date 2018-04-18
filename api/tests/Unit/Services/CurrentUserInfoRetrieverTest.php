<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Services\CurrentUserInfoRetriever;
use DentalSleepSolutions\Services\UserNumberRetriever;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;
use DentalSleepSolutions\Eloquent\Models\User as BaseUser;
use DentalSleepSolutions\Eloquent\Models\Dental\User as DentalUser;

class CurrentUserInfoRetrieverTest extends UnitTestCase
{
    /** @var CurrentUserInfoRetriever */
    private $currentUserInfoRetriever;

    /** @var DentalUser|null */
    private $dentalUser;

    /** @var DentalUser|null */
    private $doctor;

    public function setUp()
    {
        $this->dentalUser = new DentalUser();
        $this->dentalUser->use_course = 1;
        $this->doctor = new DentalUser();
        $this->doctor->status = 3;

        $userNumberRetriever = $this->mockUserNumberRetriever();
        $userRepository = $this->mockUserRepository();
        $this->currentUserInfoRetriever = new CurrentUserInfoRetriever($userNumberRetriever, $userRepository);
    }

    public function testWithUserAndDoctor()
    {
        $baseUser = new BaseUser();
        $baseUser->userid = 1;
        $baseUser->docid = 2;

        $userInfo = $this->currentUserInfoRetriever->getCurrentUserInfo($baseUser);
        $expected = [
            'number' => 1,
            'use_course' => 1,
            'doc_info' => [
                'status' => 3,
            ],
        ];
        $this->assertEquals($expected, $userInfo);
    }

    public function testWithoutUserAndDoctor()
    {
        $baseUser = new BaseUser();
        $baseUser->userid = 10;
        $baseUser->docid = 20;

        $userInfo = $this->currentUserInfoRetriever->getCurrentUserInfo($baseUser);
        $expected = [
            'number' => 1,
            'use_course' => 0,
            'doc_info' => [],
        ];
        $this->assertEquals($expected, $userInfo);
    }

    private function mockUserNumberRetriever()
    {
        /** @var MockInterface|UserNumberRetriever $userNumberRetriever */
        $userNumberRetriever = \Mockery::mock(UserNumberRetriever::class);
        $userNumberRetriever->shouldReceive('addUserNumbers')->andReturnUsing(function () {
            return [
                'number' => 1,
            ];
        });
        return $userNumberRetriever;
    }

    private function mockUserRepository()
    {
        /** @var MockInterface|UserRepository $userRepository */
        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('findOrNull')->andReturnUsing(function ($id) {
            if ($id == 1) {
                return $this->dentalUser;
            }
            if ($id == 2) {
                return $this->doctor;
            }
            return null;
        });
        return $userRepository;
    }
}
