<?php

namespace Tests\Unit\Services\InsurancePreauth;

use DentalSleepSolutions\Eloquent\Models\Dental\InsurancePreauth;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Services\InsurancePreauth\PendingVOBRemover;
use DentalSleepSolutions\Services\InsurancePreauth\PreauthHelper;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class PendingVOBRemoverTest extends UnitTestCase
{
    /** @var array */
    private $createdInsurance = [];

    /** @var array */
    private $updatedVOB = [];

    /** @var bool */
    private $shouldUpdate = true;

    /** @var bool */
    private $shouldCreate = true;

    /** @var PendingVOBRemover */
    private $pendingVOBRemover;

    public function setUp()
    {
        $preauthHelper = $this->mockPreauthHelper();
        $insurancePreauthModel = $this->mockInsurancePreauthModel();
        $this->pendingVOBRemover = new PendingVOBRemover($preauthHelper, $insurancePreauthModel);
    }

    public function testWithoutVOB()
    {
        $this->shouldUpdate = false;
        $this->shouldCreate = false;
        $user = new User();
        $user->name = 'John';
        $patientId = 1;
        $userId = 2;
        $this->pendingVOBRemover->removePendingVerificationOfBenefits($user, $patientId, $userId);
        $expectedUpdate = [
            'patientId' => 1,
            'username' => 'John',
        ];
        $this->assertEquals($expectedUpdate, $this->updatedVOB);
        $this->assertEquals([], $this->createdInsurance);
    }

    public function testWithoutUsernameAndVOB()
    {
        $this->shouldUpdate = false;
        $this->shouldCreate = false;
        $user = new User();
        $patientId = 1;
        $userId = 2;
        $this->pendingVOBRemover->removePendingVerificationOfBenefits($user, $patientId, $userId);
        $expectedUpdate = [
            'patientId' => 1,
            'username' => '',
        ];
        $this->assertEquals($expectedUpdate, $this->updatedVOB);
        $this->assertEquals([], $this->createdInsurance);
    }

    public function testWithoutInsuranceData()
    {
        $this->shouldUpdate = true;
        $this->shouldCreate = false;
        $user = new User();
        $user->name = 'John';
        $patientId = 1;
        $userId = 2;
        $this->pendingVOBRemover->removePendingVerificationOfBenefits($user, $patientId, $userId);
        $expectedUpdate = [
            'patientId' => 1,
            'username' => 'John',
        ];
        $this->assertEquals($expectedUpdate, $this->updatedVOB);
        $this->assertEquals([], $this->createdInsurance);
    }

    public function testWithInsuranceData()
    {
        $this->shouldUpdate = true;
        $this->shouldCreate = true;
        $user = new User();
        $user->name = 'John';
        $patientId = 1;
        $userId = 2;
        $this->pendingVOBRemover->removePendingVerificationOfBenefits($user, $patientId, $userId);
        $expectedUpdate = [
            'patientId' => 1,
            'username' => 'John',
        ];
        $expectedCreate = [
            'patientId' => 1,
            'userId' => 2,
        ];
        $this->assertEquals($expectedUpdate, $this->updatedVOB);
        $this->assertEquals($expectedCreate, $this->createdInsurance);
    }

    private function mockPreauthHelper()
    {
        /** @var PreauthHelper|MockInterface $preauthHelper */
        $preauthHelper = \Mockery::mock(PreauthHelper::class);
        $preauthHelper->shouldReceive('createVerificationOfBenefits')
            ->andReturnUsing([$this, 'createVOBCallback']);
        return $preauthHelper;
    }

    private function mockInsurancePreauthModel()
    {
        /** @var InsurancePreauth|MockInterface $insurancePreauthModel */
        $insurancePreauthModel = \Mockery::mock(InsurancePreauth::class);
        $insurancePreauthModel->shouldReceive('updateVob')
            ->andReturnUsing([$this, 'updateVOBCallback']);
        $insurancePreauthModel->shouldReceive('create')
            ->andReturnUsing([$this, 'createInsuranceCallback']);
        return $insurancePreauthModel;
    }

    public function updateVOBCallback($patientId, $username)
    {
        $this->updatedVOB = [
            'patientId' => $patientId,
            'username' => $username,
        ];
        return $this->shouldUpdate;
    }

    public function createVOBCallback($patientId, $userId)
    {
        if ($this->shouldCreate) {
            return [
                'patientId' => $patientId,
                'userId' => $userId,
            ];
        }
        return null;
    }

    public function createInsuranceCallback(array $data)
    {
        $this->createdInsurance = $data;
    }
}
