<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Helpers\PatientPortalRetriever;
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
        $userModel = $this->mockUserModel();
        $this->patientPortalRetriever = new PatientPortalRetriever($userModel);
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

    private function mockUserModel()
    {
        /** @var User|MockInterface $userModel */
        $userModel = \Mockery::mock(User::class);
        $userModel->shouldReceive('getWithFilter')
            ->andReturnUsing([$this, 'getWithFilterCallback']);
        return $userModel;
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
