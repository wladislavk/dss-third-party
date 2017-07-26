<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Factories\EmailHandlerFactory;
use DentalSleepSolutions\Helpers\EmailHandlers\AbstractEmailHandler;
use DentalSleepSolutions\Helpers\PatientUpdateMailer;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\RequestedEmails;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class PatientUpdateMailerTest extends UnitTestCase
{
    /** @var bool */
    private $hasHandler = false;

    /** @var string */
    private $handlerMessage = 'message';

    /** @var array */
    private $handleEmailData = [];

    /** @var PatientUpdateMailer */
    private $patientUpdateMailer;

    public function setUp()
    {
        $emailHandlerFactory = $this->mockEmailHandlerFactory();
        $this->patientUpdateMailer = new PatientUpdateMailer($emailHandlerFactory);
    }

    public function testWithHandler()
    {
        $patient = new Patient();
        $patient->patientid = 1;
        $patient->email = 'old@email.com';
        $patient->registration_status = 1;
        $requestData = new EditPatientRequestData();
        $requestData->requestedEmails = new RequestedEmails([]);
        $requestData->newEmail = 'new@email.com';
        $requestData->hasPatientPortal = true;

        $this->hasHandler = true;
        $editPatientMail = $this->patientUpdateMailer->handleEmails($patient, $requestData);
        $expected = [
            'patientId' => 1,
            'newEmail' => 'new@email.com',
            'oldEmail' => 'old@email.com',
            'hasPatientPortal' => true,
        ];
        $this->assertEquals($expected, $this->handleEmailData);
        // mocked class will not be found in types
        $this->assertFalse($editPatientMail->mailType);
        $this->assertEquals($this->handlerMessage, $editPatientMail->message);
    }

    public function testWithoutHandler()
    {
        $patient = new Patient();
        $patient->patientid = 1;
        $patient->email = 'old@email.com';
        $patient->registration_status = 1;
        $requestData = new EditPatientRequestData();
        $requestData->requestedEmails = new RequestedEmails([]);
        $requestData->newEmail = 'new@email.com';
        $requestData->hasPatientPortal = true;

        $this->hasHandler = false;
        $editPatientMail = $this->patientUpdateMailer->handleEmails($patient, $requestData);
        $this->assertEquals([], $this->handleEmailData);
        $this->assertNull($editPatientMail->mailType);
        $this->assertNull($editPatientMail->message);
    }

    private function mockEmailHandlerFactory()
    {
        /** @var EmailHandlerFactory|MockInterface $emailHandlerFactory */
        $emailHandlerFactory = \Mockery::mock(EmailHandlerFactory::class);
        $emailHandlerFactory->shouldReceive('getCorrectHandler')
            ->andReturnUsing([$this, 'getCorrectHandlerCallback']);
        return $emailHandlerFactory;
    }

    private function mockEmailHandler()
    {
        /** @var AbstractEmailHandler|MockInterface $handler */
        $handler = \Mockery::mock(AbstractEmailHandler::class);
        $handler->shouldReceive('getMessage')
            ->andReturnUsing([$this, 'getMessageCallback']);
        $handler->shouldReceive('handleEmail')
            ->andReturnUsing([$this, 'handleEmailCallback']);
        return $handler;
    }

    public function getCorrectHandlerCallback()
    {
        if ($this->hasHandler) {
            return $this->mockEmailHandler();
        }
        return null;
    }

    public function getMessageCallback()
    {
        return $this->handlerMessage;
    }

    public function handleEmailCallback($patientId, $newEmail, $oldEmail, $hasPatientPortal)
    {
        $this->handleEmailData = [
            'patientId' => $patientId,
            'newEmail' => $newEmail,
            'oldEmail' => $oldEmail,
            'hasPatientPortal' => $hasPatientPortal,
        ];
    }
}
