<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Exceptions\IncorrectEmailException;
use DentalSleepSolutions\Helpers\EmailChecker;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class EmailCheckerTest extends UnitTestCase
{
    const EXISTING_EMAIL = 'existing@email.com';

    /** @var Patient */
    private $patient;

    /** @var EmailChecker */
    private $emailChecker;

    public function setUp()
    {
        $this->patient = new Patient();
        $this->patient->registration_status = 1;
        $this->patient->use_patient_portal = 1;
        $this->patient->doc_use_patient_portal = 1;
        $this->patient->email = 'old@email.com';

        $patientRepository = $this->mockPatientRepository();
        $this->emailChecker = new EmailChecker($patientRepository);
    }

    public function testCheckWithEmailChanged()
    {
        $email = 'new@email.com';
        $patientId = 1;
        $message = $this->emailChecker->checkEmail($email, $patientId);
        $this->assertEquals(EmailChecker::EMAIL_CHANGED_MESSAGE, $message);
    }

    public function testCheckWithNotAllowedStatus()
    {
        $this->patient->registration_status = 10;
        $email = 'new@email.com';
        $patientId = 1;
        $message = $this->emailChecker->checkEmail($email, $patientId);
        $this->assertEquals('', $message);
    }

    public function testCheckWithoutPatientPortal()
    {
        $this->patient->use_patient_portal = 0;
        $email = 'new@email.com';
        $patientId = 1;
        $message = $this->emailChecker->checkEmail($email, $patientId);
        $this->assertEquals('', $message);
    }

    public function testCheckWithoutDocPatientPortal()
    {
        $this->patient->doc_use_patient_portal = 0;
        $email = 'new@email.com';
        $patientId = 1;
        $message = $this->emailChecker->checkEmail($email, $patientId);
        $this->assertEquals('', $message);
    }

    public function testCheckWithEmailUnchanged()
    {
        $email = 'old@email.com';
        $patientId = 1;
        $message = $this->emailChecker->checkEmail($email, $patientId);
        $this->assertEquals('', $message);
    }

    public function testCheckWithoutEmail()
    {
        $email = '';
        $patientId = 1;
        $this->expectException(IncorrectEmailException::class);
        $this->expectExceptionMessage(EmailChecker::EMPTY_EMAIL_MESSAGE);
        $this->emailChecker->checkEmail($email, $patientId);
    }

    public function testCheckWithEmailInUse()
    {
        $email = self::EXISTING_EMAIL;
        $patientId = 1;
        $this->expectException(IncorrectEmailException::class);
        $this->expectExceptionMessage(EmailChecker::EMAIL_IN_USE_MESSAGE);
        $this->emailChecker->checkEmail($email, $patientId);
    }

    private function mockPatientRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('getPatientInfoWithDocInfo')
            ->andReturnUsing([$this, 'getPatientInfoWithDocInfoCallback']);
        $patientRepository->shouldReceive('getSameEmails')
            ->andReturnUsing([$this, 'getSameEmailsCallback']);
        return $patientRepository;
    }

    public function getPatientInfoWithDocInfoCallback()
    {
        return $this->patient;
    }

    public function getSameEmailsCallback($email, $patientId)
    {
        if ($email == self::EXISTING_EMAIL) {
            return 1;
        }
        return 0;
    }
}
