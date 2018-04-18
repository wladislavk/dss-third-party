<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Services\EmailHandlers\RegistrationEmailHandler;
use DentalSleepSolutions\Services\MailerDataRetriever;
use DentalSleepSolutions\Services\PdfHelper;
use DentalSleepSolutions\Services\TempPinDocumentCreator;
use DentalSleepSolutions\Structs\MailerData;
use DentalSleepSolutions\Structs\PdfHeaderData;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class TempPinDocumentCreatorTest extends UnitTestCase
{
    const URL = 'pdf_url';

    /** @var int */
    private $accessType;

    /** @var string */
    private $patientEmail;

    /** @var string */
    private $userEmail;

    /** @var array */
    private $handledEmail = [];

    /** @var array */
    private $createdPdf = [];

    /** @var TempPinDocumentCreator */
    private $tempPinDocumentCreator;

    public function setUp()
    {
        $this->patientEmail = 'patient@email.com';
        $this->userEmail = 'user@email.com';

        $mailerDataRetriever = $this->mockMailerDataRetriever();
        $registrationEmailHandler = $this->mockRegistrationEmailHandler();
        $pdfHelper = $this->mockPDFHelper();
        $this->tempPinDocumentCreator = new TempPinDocumentCreator(
            $mailerDataRetriever, $registrationEmailHandler, $pdfHelper
        );
    }

    public function testCreateDocument()
    {
        $patientId = 1;
        $docId = 2;
        $url = $this->tempPinDocumentCreator->createDocument($patientId, $docId);
        $this->assertEquals(TempPinDocumentCreator::REGISTRATION_ACCESS_TYPE, $this->accessType);
        $handledEmail = [
            'patientId' => 1,
            'newEmail' => 'user@email.com',
            'oldEmail' => 'user@email.com',
        ];
        $this->assertEquals($handledEmail, $this->handledEmail);
        $this->assertEquals(self::URL, $url);
        $this->assertEquals(TempPinDocumentCreator::PDF_TEMPLATE, $this->createdPdf['template']);
        $content = [
            'patientid' => 1,
            'docid' => 2,
            'email' => 'user@email.com',
        ];
        $this->assertEquals($content, $this->createdPdf['content']);
        $this->assertEquals(sprintf(TempPinDocumentCreator::FILENAME_TEMPLATE, 1), $this->createdPdf['filename']);
        /** @var PdfHeaderData $headerInfo */
        $headerInfo = $this->createdPdf['headerInfo'];
        $this->assertEquals(TempPinDocumentCreator::HEADER_TITLE, $headerInfo->title);
        $this->assertEquals(TempPinDocumentCreator::HEADER_TITLE, $headerInfo->subject);
        $this->assertEquals(2, $this->createdPdf['docId']);
    }

    public function testWithBadDataArray()
    {
        $this->patientEmail = null;
        $this->userEmail = null;
        $patientId = 1;
        $docId = 2;
        $url = $this->tempPinDocumentCreator->createDocument($patientId, $docId);
        $this->assertEquals('', $url);
        $this->assertEquals([], $this->handledEmail);
    }

    private function mockMailerDataRetriever()
    {
        /** @var MailerDataRetriever|MockInterface $mailerDataRetriever */
        $mailerDataRetriever = \Mockery::mock(MailerDataRetriever::class);
        $mailerDataRetriever->shouldReceive('retrieveMailerData')
            ->andReturnUsing([$this, 'retrieveMailerDataCallback']);
        return $mailerDataRetriever;
    }

    private function mockRegistrationEmailHandler()
    {
        /** @var RegistrationEmailHandler|MockInterface $registrationEmailHandler */
        $registrationEmailHandler = \Mockery::mock(RegistrationEmailHandler::class);
        $registrationEmailHandler->shouldReceive('setAccessType')
            ->andReturnUsing([$this, 'setAccessTypeCallback']);
        $registrationEmailHandler->shouldReceive('handleEmail')
            ->andReturnUsing([$this, 'handleEmailCallback']);
        return $registrationEmailHandler;
    }

    private function mockPDFHelper()
    {
        /** @var PdfHelper|MockInterface $pdfHelper */
        $pdfHelper = \Mockery::mock(PdfHelper::class);
        $pdfHelper->shouldReceive('create')->andReturnUsing([$this, 'createPDFCallback']);
        return $pdfHelper;
    }

    public function retrieveMailerDataCallback($patientId, $docId)
    {
        $patient = new Patient();
        $patient->patientid = $patientId;
        $patient->docid = $docId;
        if ($this->patientEmail) {
            $patient->email = $this->patientEmail;
        }
        $user = new User();
        $user->docid = $docId;
        if ($this->userEmail) {
            $user->email = $this->userEmail;
        }
        $mailerData = new MailerData();
        $mailerData->patientData = $patient;
        $mailerData->mailingData = $user;
        return $mailerData;
    }

    public function setAccessTypeCallback($accessType)
    {
        $this->accessType = $accessType;
    }

    public function handleEmailCallback($patientId, $newEmail, $oldEmail)
    {
        $this->handledEmail = [
            'patientId' => $patientId,
            'newEmail' => $newEmail,
            'oldEmail' => $oldEmail,
        ];
    }

    public function createPDFCallback($template, array $content, $filename, PdfHeaderData $headerInfo, $docId)
    {
        $this->createdPdf = [
            'template' => $template,
            'content' => $content,
            'filename' => $filename,
            'headerInfo' => $headerInfo,
            'docId' => $docId,
        ];
        return self::URL;
    }
}
