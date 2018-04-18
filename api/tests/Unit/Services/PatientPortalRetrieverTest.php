<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\Services\PatientPortalRetriever;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class PatientPortalRetrieverTest extends UnitTestCase
{
    /** @var bool */
    private $docPatientPortal = true;

    /** @var PatientPortalRetriever */
    private $patientPortalRetriever;

    public function setUp()
    {
        $userRepository = $this->mockUserRepository();
        $this->patientPortalRetriever = new PatientPortalRetriever($userRepository);
    }

    public function testHasPatientPortal()
    {
        $docId = 1;
        $usePatientPortal = true;
        $hasPatientPortal = $this->patientPortalRetriever->hasPatientPortal($docId, $usePatientPortal);
        $this->assertTrue($hasPatientPortal);
    }

    public function testWithoutUsePatientPortal()
    {
        $docId = 1;
        $usePatientPortal = false;
        $hasPatientPortal = $this->patientPortalRetriever->hasPatientPortal($docId, $usePatientPortal);
        $this->assertFalse($hasPatientPortal);
    }

    public function testWithoutDocInfo()
    {
        $docId = 2;
        $usePatientPortal = true;
        $hasPatientPortal = $this->patientPortalRetriever->hasPatientPortal($docId, $usePatientPortal);
        $this->assertFalse($hasPatientPortal);
    }

    public function testWithoutDocPatientPortal()
    {
        $this->docPatientPortal = false;
        $docId = 1;
        $usePatientPortal = true;
        $hasPatientPortal = $this->patientPortalRetriever->hasPatientPortal($docId, $usePatientPortal);
        $this->assertFalse($hasPatientPortal);
    }

    private function mockUserRepository()
    {
        /** @var UserRepository|MockInterface $userRepository */
        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getWithFilter')
            ->andReturnUsing([$this, 'getWithFilterCallback']);
        return $userRepository;
    }

    public function getWithFilterCallback(array $fields, array $where)
    {
        if ($where['userid'] == 1) {
            $user1 = new User();
            $user1->userid = 1;
            $user1->use_patient_portal = $this->docPatientPortal;
            $user2 = new User();
            $user2->userid = 2;
            $user2->use_patient_portal = $this->docPatientPortal;
            return [$user1, $user2];
        }
        return [];
    }
}
