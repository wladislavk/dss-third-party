<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\Summary;
use DentalSleepSolutions\Eloquent\Dental\User;

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
     *
     * @return array
     */
    public function retrieveMailerData($patientId, $docId = 0)
    {
        /** @var Patient|null $patient */
        $patient = $this->patientModel->find($patientId);
        $summaryInfo = $this->summaryModel->getWithFilter('location', ['patientid' => $patientId]);
        $location = 0;
        if (isset($summaryInfo[0])) {
            $location = $summaryInfo[0]->location;
        }

        $mailingData = $this->userModel->getMailingData($docId, $patientId, $location);
        $mailingData = $this->setMailingDataLogo($mailingData);
        $mailingData->mailing_phone = $this->generalHelper->formatPhone($mailingData->mailing_phone);

        return [
            'patientData' => $patient->toArray(),
            'mailingData' => $mailingData->toArray(),
        ];
    }

    /**
     * @param User $mailingData
     * @return User
     */
    private function setMailingDataLogo(User $mailingData)
    {
        $mailingData->logo = self::LOGO;
        if (
            $mailingData->user_type == self::DSS_USER_TYPE_SOFTWARE
            &&
            $this->generalHelper->isSharedFile($mailingData->logo)
        ) {
            $mailingData->logo = self::DISPLAY_FILE_PAGE . '?f=' . $mailingData->logo;
        }
        return $mailingData;
    }
}
