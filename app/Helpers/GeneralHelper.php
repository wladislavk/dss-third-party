<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Structs\ContactData;
use DentalSleepSolutions\Wrappers\FileWrapper;

// this class contains some functions from general_functions.php
class GeneralHelper
{
    // TODO: what's a Q?
    const Q_FILE_FOLDER = '';

    /** @var FileWrapper */
    private $fileWrapper;

    /** @var Patient */
    private $patientModel;

    /** @var Contact */
    private $contactModel;

    public function __construct(FileWrapper $fileWrapper, Patient $patient, Contact $contact)
    {
        $this->fileWrapper = $fileWrapper;
        $this->patientModel = $patient;
        $this->contactModel = $contact;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isSharedFile($name)
    {
        if (strlen($name) && $this->fileWrapper->isFile(self::Q_FILE_FOLDER . $name)) {
            return true;
        }
        return false;
    }

    /**
     * @param string $data
     * @return null|string
     */
    public function formatPhone($data)
    {
        preg_match('/.*?(\d{3}).*?(\d{3}).*?(\d{4}).*?(\d*)$/', $data, $matches);
        if (sizeof($matches) < 4) {
            return null;
        }
        $result = '(' . $matches[1] . ') ' . $matches[2] . '-' . $matches[3];
        if (isset($matches[4]) && $matches[4] != '') {
          $result .= ' x' . $matches[4];
        }
        return $result;
    }

    /**
     * Retrieve Names Salutation and more from Database
     * Returns an array of the form [patient, mds, or md_referrals][id]['fieldname']
     *
     * @param int $patient
     * @param string $mdList
     * @param string $mdReferralList
     * @param string|null $patientReferralList
     * @param int $letterId
     * @return ContactData
     */
    public function getContactInfo(
        $patient,
        $mdList,
        $mdReferralList,
        $patientReferralList = null,
        $letterId = 0
    ) {
        $contactInfo = new ContactData();
        $mdList = $this->clearIdList($mdList);
        $mdReferralList = $this->clearIdList($mdReferralList);
        $patientReferralList = $this->clearIdList($patientReferralList);
        if ($patient) {
            $patientContactData = $this->patientModel->getContactInfo($letterId, $patient);
            $contactInfo->setPatients($patientContactData);
        }
        if ($mdList) {
            $mdContactData = $this->contactModel->getContactInfo($letterId, $mdList);
            $contactInfo->setMds($mdContactData);
        }
        if ($mdReferralList) {
            $mdReferralContactData = $this->contactModel->getContactInfo($letterId, $mdReferralList);
            $contactInfo->setMdReferrals($mdReferralContactData);
        }
        if ($patientReferralList) {
            $patientReferralContactData = $this->patientModel->getReferralList($letterId, $patientReferralList);
            $contactInfo->setPatientReferrals($patientReferralContactData);
        }
        return $contactInfo;
    }

    /**
     * @param string|null $stringList
     * @return string|null
     */
    private function clearIdList($stringList)
    {
        $stringList = preg_replace('/,+/', ',', $stringList);
        if ($stringList === '' || $stringList === ',') {
            return null;
        }
        return $stringList;
    }
}
