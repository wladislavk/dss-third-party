<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Factories\EmailHandlerFactory;
use DentalSleepSolutions\Helpers\EmailHandlers\RegistrationEmailHandler;
use DentalSleepSolutions\Helpers\RegistrationEmailSender;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class RegistrationEmailSenderTest extends UnitTestCase
{
    /** @var array */
    private $handledEmail = [];

    /** @var RegistrationEmailSender */
    private $registrationEmailSender;

    public function setUp()
    {
        $registrationEmailHandler = $this->mockRegistrationEmailHandler();
        $this->registrationEmailSender = new RegistrationEmailSender($registrationEmailHandler);
    }

    public function testSendRegistrationEmail()
    {
        $responseData = new EditPatientResponseData();
        $requestData = new EditPatientRequestData();
        $requestData->newEmail = 'new@email.com';
        $requestData->cellphone = '223322';
        $patient = new Patient();
        $patient->patientid = 1;
        $patient->email = 'old@email.com';
        $this->registrationEmailSender->sendRegistrationEmail($responseData, $requestData, $patient);
        $expected = [
            'patientId' => 1,
            'newEmail' => 'new@email.com',
            'oldEmail' => 'old@email.com',
            'hasPatientPortal' => true,
        ];
        $this->assertEquals($expected, $this->handledEmail);
        $this->assertEquals(EmailHandlerFactory::REGISTRATION_MAIL, $responseData->mails->mailType);
        $this->assertEquals(RegistrationEmailSender::SUCCESS_MESSAGE, $responseData->mails->message);
    }

    public function testSendWithoutPatientIdAndOldEmail()
    {
        $responseData = new EditPatientResponseData();
        $requestData = new EditPatientRequestData();
        $requestData->newEmail = 'new@email.com';
        $requestData->cellphone = '223322';
        $this->registrationEmailSender->sendRegistrationEmail($responseData, $requestData);
        $expected = [
            'patientId' => 0,
            'newEmail' => 'new@email.com',
            'oldEmail' => '',
            'hasPatientPortal' => true,
        ];
        $this->assertEquals($expected, $this->handledEmail);
        $this->assertEquals(EmailHandlerFactory::REGISTRATION_MAIL, $responseData->mails->mailType);
        $this->assertEquals(RegistrationEmailSender::SUCCESS_MESSAGE, $responseData->mails->message);
    }

    public function testSendWithoutEmailAndPhone()
    {
        $responseData = new EditPatientResponseData();
        $requestData = new EditPatientRequestData();
        $this->registrationEmailSender->sendRegistrationEmail($responseData, $requestData);
        $this->assertEquals([], $this->handledEmail);
        $this->assertEquals(EmailHandlerFactory::REGISTRATION_MAIL, $responseData->mails->mailType);
        $this->assertEquals(RegistrationEmailSender::FAILURE_MESSAGE, $responseData->mails->message);
    }

    private function mockRegistrationEmailHandler()
    {
        /** @var RegistrationEmailHandler|MockInterface $registrationEmailHander */
        $registrationEmailHander = \Mockery::mock(RegistrationEmailHandler::class);
        $registrationEmailHander->shouldReceive('handleEmail')
            ->andReturnUsing([$this, 'handleEmailCallback']);
        return $registrationEmailHander;
    }

    public function handleEmailCallback($patientId, $newEmail, $oldEmail, $hasPatientPortal)
    {
        $this->handledEmail = [
            'patientId' => $patientId,
            'newEmail' => $newEmail,
            'oldEmail' => $oldEmail,
            'hasPatientPortal' => $hasPatientPortal,
        ];
    }
}
