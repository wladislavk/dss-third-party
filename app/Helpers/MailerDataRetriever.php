<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\Summary;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Exceptions\EmailHandlerException;
use DentalSleepSolutions\Structs\MailerData;

class MailerDataRetriever
{
    const DSS_USER_TYPE_SOFTWARE = 2;

    const LOGO = 'foreign_images/email/reg_logo.gif';

    // TODO: do these pages still exist? if so, all references to them should have their own namespace
    const DISPLAY_FILE_PAGE = 'manage/display_file.php';

    /** @var GeneralHelper */
    private $generalHelper;

    /** @var User */
    private $userModel;

    /** @var Patient */
    private $patientModel;

    /** @var Summary */
    private $summaryModel;

    public function __construct(
        GeneralHelper $generalHelper,
        User $userModel,
        Patient $patientModel,
        Summary $summaryModel
    ) {
        $this->generalHelper = $generalHelper;
        $this->userModel = $userModel;
        $this->patientModel = $patientModel;
        $this->summaryModel = $summaryModel;
    }

    /**
     * Retrieve patient and mailing doctor details, for patient emails
     *
     * @param int $patientId
     * @param int $docId
     * @return MailerData
     * @throws EmailHandlerException
     */
    public function retrieveMailerData($patientId, $docId = 0)
    {
        /** @var Patient|null $patient */
        $patient = $this->patientModel->find($patientId);
        if (!$patient) {
            throw new EmailHandlerException("Patient with ID $patientId not found");
        }
        $summaryInfo = $this->summaryModel->getWithFilter('location', ['patientid' => $patientId]);
        $location = 0;
        if (isset($summaryInfo[0])) {
            $location = $summaryInfo[0]->location;
        }

        $mailingData = $this->userModel->getMailingData($docId, $patientId, $location);
        if (!$mailingData) {
            throw new EmailHandlerException("Mailing data for patient with ID $patientId not found");
        }
        $mailingData = $this->setMailingDataLogo($mailingData);
        $mailingData->mailing_phone = $this->generalHelper->formatPhone($mailingData->mailing_phone);

        $mailerData = new MailerData();
        $mailerData->patientData = $patient;
        $mailerData->mailingData = $mailingData;
        return $mailerData;
    }

    /**
     * @param User $mailingData
     * @return User
     */
    private function setMailingDataLogo(User $mailingData)
    {
        $logo = self::LOGO;
        if (
            $mailingData->user_type == self::DSS_USER_TYPE_SOFTWARE
            &&
            $this->generalHelper->isSharedFile($mailingData->logo)
        ) {
            $logo = self::DISPLAY_FILE_PAGE . '?f=' . $mailingData->logo;
        }
        $mailingData->logo = $logo;
        return $mailingData;
    }
}
