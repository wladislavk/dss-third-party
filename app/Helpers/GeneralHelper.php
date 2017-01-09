<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\Contact;

// this class contains some functions from general_functions.php
class GeneralHelper
{
    private $patient;
    private $contact;

    public function __construct(Patient $patient, Contact $contact)
    {
        $this->patient = $patient;
        $this->contact = $contact;
    }

    public function function isSharedFile($name)
    {
        return strlen($name) && is_file(Q_FILE_FOLDER . $name);
    }

    public function formatPhone($data)
    {
        if (preg_match('/.*(\d{3}).*(\d{3}).*(\d{4}).*(\d*)$/', $data, $matches)) {
            $result = '(' . $matches[1] . ') ' . $matches[2] . '-' . $matches[3];
            if ($matches[4] != '') {
              $result .= ' x' . $matches[4];
            }

            return $result;
        }
    }

    /**
     * Retrieve template from the template folder
     *
     * @param string $filename
     * @return string
     */

    // need to rewrite to the structure of Laravel
    public function getTemplate($filename)
    {
        $templatePath = __DIR__ . '/../admin/includes/templates';

        $sections = explode('/', $filename);
        $sections = array_filter($sections);
        $sections = preg_replace('/[^a-z0-9_-]+/', '', $sections);

        $filename = join('/', $sections);

        if (!file_exists("$templatePath/$filename.tpl")) {
            return '';
        }

        return file_get_contents("$templatePath/$filename.tpl");
    }

    // Retrieve Names Salutation and more from Database
    // Returns an array of the form [patient, mds, or md_referrals][id]['fieldname']
    public function getContactInfo($patient, $mdList, $mdReferralList, $patReferralList = null, $letterId = 0)
    {
        $contactInfo = [];

        $patient = $this->clearIdList($patient);
        $mdList = $this->clearIdList($mdList);
        $mdReferralList = $this->clearIdList($mdReferralList);
        $patReferralList = $this->clearIdList($patReferralList);

        if (isset($patient)) {
            $contactData = $this->patient->getContactInfo($letterId, $patient);

            if (count($contactData)) {
                foreach ($contactData as $contact) {
                    $contactInfo['patient'][] = $contact->toArray();
                }
            }
        }

        if (isset($mdList) && $mdList != "") {
            $contactData = $this->contact->getContactInfo($letterId, $mdList);

            if (count($contactData)) {
                foreach ($contactData as $contact) {
                    $contactInfo['mds'][] = $contact->toArray();
                }
            }
        }

        if (isset($mdReferralList) && $mdReferralList != "") {
            $contactData = $this->contact->getContactInfo($letterId, $mdReferralList);

            if (count($contactData)) {
                foreach ($contactData as $contact) {
                    $contactInfo['md_referrals'][] = $contact->toArray();
                }
            }
        }

        if (isset($patReferralList) && $patReferralList != "") {
            $contactData = $this->patient->getReferralList($letterId, $patReferralList);

            if (count($contactData)) {
                foreach ($contactData as $contact) {
                    $contactInfo['pat_referrals'][] = $contact->toArray();
                }
            }
        }

        return $contactInfo;
    }

    public function clearIdList($stringList)
    {
        if (!isset($stringList)) {
            return $stringList;
        }

        $stringList = preg_replace('/,+/', ',', $stringList);

        // Add a default value here
        if ($stringList === '' || $stringList === ',') {
            $stringList = null;
        }

        return $stringList;
    }
}
