<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use DentalSleepSolutions\Services\AppointmentSummaries\UniqueTmjCreator;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class UniqueTmjCreatorTest extends UnitTestCase
{
    private const PATIENT_ID = 42;
    private const EXISTING_PATIENT_ID = 43;
    private const USER_ID = 12;
    private const DOC_ID = 18;
    private const DEVICE_ID = 23;
    private const EXISTING_DEVICE_ID = 24;

    /** @var User */
    private $user;

    /** @var TmjClinicalExam|null */
    private $existingTmj;

    /** @var UniqueTmjCreator */
    private $uniqueTmjCreator;

    public function setUp()
    {
        $this->user = new User();
        $this->user->userid = self::USER_ID;
        $this->user->docid = self::DOC_ID;

        $repository = $this->mockTmjClinicalExamRepository();
        $this->uniqueTmjCreator = new UniqueTmjCreator($repository);
    }

    public function testCreateTmj()
    {
        $tmj = $this->uniqueTmjCreator->createUniqueTmj($this->user, self::PATIENT_ID, self::DEVICE_ID);
        $this->assertEquals(self::USER_ID, $tmj->userid);
        $this->assertEquals(self::DOC_ID, $tmj->docid);
        $this->assertEquals(self::PATIENT_ID, $tmj->patientid);
        $this->assertEquals(self::DEVICE_ID, $tmj->dentaldevice);
    }

    public function testUpdateTmj()
    {
        $this->existingTmj = new TmjClinicalExam();
        $this->existingTmj->patientid = self::EXISTING_PATIENT_ID;
        $this->existingTmj->dentaldevice = self::EXISTING_DEVICE_ID;

        $tmj = $this->uniqueTmjCreator->createUniqueTmj($this->user, self::PATIENT_ID, self::DEVICE_ID);
        $this->assertEquals(self::EXISTING_PATIENT_ID, $tmj->patientid);
        $this->assertEquals(self::DEVICE_ID, $tmj->dentaldevice);
    }

    private function mockTmjClinicalExamRepository()
    {
        /** @var TmjClinicalExamRepository|MockInterface $repository */
        $repository = \Mockery::mock(TmjClinicalExamRepository::class);
        $repository->shouldReceive('getOneBy')->andReturnUsing(function () {
            return $this->existingTmj;
        });
        return $repository;
    }
}
