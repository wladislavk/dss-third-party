<?php

namespace Tests\Unit\Services\Emails;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Factories\EmailHandlerFactory;
use DentalSleepSolutions\Services\Emails\EmailHandlers\RegistrationEmailHandler;
use DentalSleepSolutions\Services\Emails\RegistrationEmailSender;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use DentalSleepSolutions\Structs\RequestedEmails;
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
        $requestData->hasPatientPortal = true;
        $requestData->requestedEmails = new RequestedEmails(['registration' => true]);
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
        $requestData->hasPatientPortal = true;
        $requestData->requestedEmails = new RequestedEmails(['registration' => true]);
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
        $requestData->hasPatientPortal = true;
        $requestData->requestedEmails = new RequestedEmails(['registration' => true]);
        $this->registrationEmailSender->sendRegistrationEmail($responseData, $requestData);
        $this->assertEquals([], $this->handledEmail);
        $this->assertEquals(EmailHandlerFactory::REGISTRATION_MAIL, $responseData->mails->mailType);
        $this->assertEquals(RegistrationEmailSender::FAILURE_MESSAGE, $responseData->mails->message);
    }

    public function testSendWithBadRequestedEmails()
    {
        $responseData = new EditPatientResponseData();
        $requestData = new EditPatientRequestData();
        $requestData->hasPatientPortal = true;
        $requestData->requestedEmails = new RequestedEmails([]);
        $this->registrationEmailSender->sendRegistrationEmail($responseData, $requestData);
        $this->assertEquals([], $this->handledEmail);
        $this->assertNull($responseData->mails);
    }

    public function testSendWithoutPatientPortal()
    {
        $responseData = new EditPatientResponseData();
        $requestData = new EditPatientRequestData();
        $requestData->hasPatientPortal = false;
        $requestData->requestedEmails = new RequestedEmails(['registration' => true]);
        $this->registrationEmailSender->sendRegistrationEmail($responseData, $requestData);
        $this->assertEquals([], $this->handledEmail);
        $this->assertNull($responseData->mails);
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
