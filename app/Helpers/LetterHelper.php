<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Letter;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\Contact;
use DentalSleepSolutions\Eloquent\Dental\User;

class LetterHelper
{
    private $letter;
    private $patient;
    private $contact;
    private $user;

    private $docId;
    private $patientId;
    private $userType;

    public function __construct(
        Letter $letter,
        Patient $patient,
        Contact $contact,
        User $user,
        $docId,
        $patientId,
        $userType
    ) {
        $this->letter = $letter;
        $this->patient = $patient;
        $this->contact = $contact;
        $this->user = $user;

        $this->docId = $docId;
        $this->patientId = $patientId;
        $this->userType = $userType;
    }

    public function triggerPatientTreatmentComplete()
    {
        if ($this->patientId) {
            $currentPatient = $this->patient->getWithFilter([
                'referred_source', 'docsleep', 'docpcp', 'docdentist',
                'docent', 'docmdother', 'docmdother2', 'docmdother3'
            ], [
                'patientid' => $this->patientId
            ]);
        }

        $patientReferralIds = $this->patient->getPatientReferralIds($this->patientId, $currentPatient[0]);

        $letterId = 0;

        if ($patientReferralIds) {
            $letters = $this->letter->getPatientTreatmentComplete($this->patientId, $patientReferralIds);

            if (!count($letters)) {
                $contactIds = $this->contact->getMdContactIds($this->patientId, $currentPatient);

                $letterId = $this->createLetter($letterid, $pid, '', '', '', '', $pt_referral_list);
            }
        }

        return $letterId;
    }

    public function triggerIntroLettersOf12Types($mdContacts = [])
    {
        // trigger intro letter to MD from DSSFLLC and intro letter to MD from Franchisee
        $userLetterInfo = $this->user->getWithFilter(['use_letters', 'intro_letters'], [
            'userid' => $this->docId
        ]);

        if ($userLetterInfo && $userLetterInfo->use_letters && $userLetterInfo->intro_letters) {
            $letter1Id = 1;
            $letter2Id = 2;

            $recipients = [];
            if (count($mdContacts)) {
                foreach ($mdContacts as $contact) {
                    if ($contact != "Not Set") {
                        $mdLists = $this->letter->getMdList($contact, $letter1Id, $letter2Id);

                        if (count($mdLists) && $contact != "") {
                            $foundContact = $this->contact->getActiveContact($contact);

                            if ($foundContact) {
                                $recipients[] = $contact;
                            }
                        }
                    }
                }
            }

            $createdLetter1Id = 0;
            $createdLetter2Id = 0;

            if (count($recipients)) {
                $recipientsList = implode(',', $recipients);

                $createdLetter2Id = $this->createLetter($letter2Id, $this->patientId, '', '', $recipientsList);

                //DO NOT SENT LETTER 1 (FROM DSS) TO SOFTWARE USER
                if ($this->userType == self::DSS_USER_TYPE_SOFTWARE) {
                    $createdLetter1Id = $this->createLetter($letter1Id, $this->patientId, '', '', $recipientsList);
                }
            }

            $data = [
                'letter_1_id' => $createdLetter1Id,
                'letter_2_id' => $createdLetter2Id
            ];
        } else {
            $data = null;
        }

        return $data;
    }

    public function triggerIntroLetterOf3Type()
    {
        // trigger intro letter to DSS Patient of Record
        $letterId = 3;
        $toPatient = 1;

        $letterId = $this->createLetter($letterId, $this->patientId, '', $toPatient);

        return $letterId;
    }

    public function deleteLetter()
    {
        
    }

    private function createLetter($data = []) {
        if ($this->docId > 0) {
            $user = $this->user->getWithFilter(['use_letters'], [
                'userid' => $this->docId
            ]);

            if ($user && $user->use_letters != 1) {
                return -1;
            }
        }

        if ((!$data['to_patient'] && !$data['md_referral_list'] && !$data['md_list'] && !$data['patient_referral_list']) ||
            ($data['check_recipient'] && !$data['md_referral_list'] && !$data['md_list'] &&
            ($data['templateid'] == 16 || $data['templateid'] == 19))
        ) {
            return false;
        }

        if (!isset($data['templateid'])) {
            return "Error: Letter Template not specified";
        }

        //To remove referral source from md list if exists
        $mdArray = explode(',', $data['md_list']);
        $mdArray = array_filter($mdArray, [new MDReferralFilter($data['md_referral_list']), 'isReferrer']);
        $data['md_list'] = implode(',', $mdArray);

        $data['user_id'] = $this->userId;
        $data['doc_id'] = $this->docId;

        $createdLetter = $this->letter->createLetter($data);

        if ($createdLetter) {
            return $createdLetter->letterid;
        } else {
            return 0;
        }
    }
}
