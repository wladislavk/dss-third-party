<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Helpers\EmailHandlers\RegistrationEmailHandler;
use DentalSleepSolutions\Structs\PdfHeaderData;

class TempPinDocumentCreator
{
    const HEADER_TITLE = 'User Temporary PIN';
    const FILENAME_TEMPLATE = 'user_pin_%d.pdf';
    const PDF_TEMPLATE = 'pdf.patient.pinInstructions';

    // TODO: eliminate magic number
    const REGISTRATION_ACCESS_TYPE = 2;

    /** @var MailerDataRetriever */
    private $mailerDataRetriever;

    /** @var RegistrationEmailHandler */
    private $registrationEmailHandler;

    /** @var PdfHelper */
    private $pdfHelper;

    public function __construct(
        MailerDataRetriever $mailerDataRetriever,
        RegistrationEmailHandler $registrationEmailHandler,
        PdfHelper $pdfHelper
    ) {
        $this->mailerDataRetriever = $mailerDataRetriever;
        $this->registrationEmailHandler = $registrationEmailHandler;
        $this->pdfHelper = $pdfHelper;
    }

    /**
     * @param int $patientId
     * @param int $docId
     * @return string
     */
    public function createDocument($patientId, $docId)
    {
        $mailerData = $this->mailerDataRetriever->retrieveMailerData($patientId, $docId);
        $mailerDataArray = array_merge(
            $mailerData->patientData->toArray(),
            $mailerData->mailingData->toArray()
        );

        if (!count($mailerDataArray) || !isset($mailerDataArray['email'])) {
            return '';
        }
        $email = $mailerDataArray['email'];
        $this->registrationEmailHandler->setAccessType(self::REGISTRATION_ACCESS_TYPE);
        $this->registrationEmailHandler->handleEmail($patientId, $email, $email);

        $filename = sprintf(self::FILENAME_TEMPLATE, $patientId);
        $headerInfo = new PdfHeaderData();
        $headerInfo->title = self::HEADER_TITLE;
        $headerInfo->subject = self::HEADER_TITLE;

        $url = $this->pdfHelper->create(
            self::PDF_TEMPLATE, $mailerDataArray, $filename, $headerInfo, $docId
        );
        return $url;
    }
}
