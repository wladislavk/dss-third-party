<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\Summary;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Exceptions\EmailHandlerException;

class MailerDataRetriever
{
    const DSS_USER_TYPE_SOFTWARE = 2;

    const LOGO = 'foreign_images/email/reg_logo.gif';

    // TODO: do these pages still exist? if so, all references to them should have their own namespace
    const DISPLAY_FILE_PAGE = 'manage/display_file.php';

    /** @var GeneralHelper */
    private $generalHelper;

    /** @var UserRepository */
    private $userRepository;

    /** @var PatientRepository */
    private $patientRepository;

    /** @var Summary */
    private $summaryModel;

    public function __construct(
        GeneralHelper $generalHelper,
        UserRepository $userRepository,
        PatientRepository $patientRepository,
        Summary $summaryModel
    ) {
        $this->generalHelper = $generalHelper;
        $this->userRepository = $userRepository;
        $this->patientRepository = $patientRepository;
        $this->summaryModel = $summaryModel;
    }

    /**
     * Retrieve patient and mailing doctor details, for patient emails
     *
     * @param int $patientId
     * @param int $docId
     * @return array
     * @throws EmailHandlerException
     */
    public function retrieveMailerData($patientId, $docId = 0)
    {
        /** @var Patient|null $patient */
        $patient = $this->patientRepository->find($patientId);
        if (!$patient) {
            throw new EmailHandlerException("Patient with ID $patientId not found");
        }
        $summaryInfo = $this->summaryModel->getWithFilter('location', ['patientid' => $patientId]);
        $location = 0;
        if (isset($summaryInfo[0])) {
            $location = $summaryInfo[0]->location;
        }

        $mailingData = $this->userRepository->getMailingData($docId, $patientId, $location);
        if (!$mailingData) {
            throw new EmailHandlerException("Mailing data for patient with ID $patientId not found");
        }
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
