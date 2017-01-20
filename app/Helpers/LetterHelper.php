<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Letter;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\Contact;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Eloquent\Dental\Fax;

use DentalSleepSolutions\Helpers\GeneralHelper;

use Carbon\Carbon;

class LetterHelper
{
    private $letter;
    private $patient;
    private $contact;
    private $user;
    private $fax;

    private $generalHelper;

    private $docId;
    private $patientId;
    private $userType;

    public function __construct(
        Letter $letter,
        Patient $patient,
        Contact $contact,
        User $user,
        Fax $fax,
        GeneralHelper $generalHelper,
        $docId = 0,
        $patientId = 0,
        $userType = 0
    ) {
        $this->letter = $letter;
        $this->patient = $patient;
        $this->contact = $contact;
        $this->user = $user;
        $this->fax = $fax;

        $this->generalHelper = $generalHelper;

        $this->docId = $docId;
        $this->patientId = $patientId;
        $this->userType = $userType;
    }

    public function setIdentificators($docId, $patientId, $userType)
    {
        $this->docId = $docId;
        $this->patientId = $patientId;
        $this->userType = $userType;
    }

    public function triggerPatientTreatmentComplete()
    {
        if ($this->patientId) {
            $foundPatients = $this->patient->getWithFilter([
                'referred_source', 'docsleep', 'docpcp', 'docdentist',
                'docent', 'docmdother', 'docmdother2', 'docmdother3'
            ], [
                'patientid' => $this->patientId
            ]);
        }

        $currentPatient = !empty($foundPatients) ? $foundPatients[0] : null;
        $patientReferralIds = $this->patient->getPatientReferralIds($this->patientId, $currentPatient);

        $letterId = 0;

        if ($patientReferralIds) {
            $letters = $this->letter->getPatientTreatmentComplete($this->patientId, $patientReferralIds);

            if (!count($letters)) {
                // this logic exists in the legacy code, but is not used anywhere
                // $contactIds = $this->contact->getMdContactIds($this->patientId, $currentPatient);

                $letterId = $this->createLetter($id = 20, ['pid' => $this->patientId, 'pat_referral_list' => $patientReferralIds]);
            }
        }

        return $letterId;
    }

    public function triggerIntroLettersOf12Types($patientId, $mdContacts = [])
    {
        // trigger intro letter to MD from DSSFLLC and intro letter to MD from Franchisee
        $userLetterInfo = $this->user->getWithFilter(['use_letters', 'intro_letters'], [
            'userid' => $this->docId
        ]);

        $userLetterInfo = count($userLetterInfo) ? $userLetterInfo[0] : null;

        if (!empty($userLetterInfo) && $userLetterInfo->use_letters && $userLetterInfo->intro_letters) {
            $letter1Id = 1;
            $letter2Id = 2;

            $recipients = [];
            if (count($mdContacts)) {
                foreach ($mdContacts as $contact) {
                    if ($contact > 0) {
                        $mdLists = $this->letter->getMdList($contact, $letter1Id, $letter2Id);

                        if (count($mdLists)) {
                            $foundContact = $this->contact->getActiveContact($contact);

                            if (!empty($foundContact)) {
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

                $createdLetter2Id = $this->createLetter($letter2Id, ['pid' => $this->patientId, 'md_list' => $recipientsList]);

                //DO NOT SENT LETTER 1 (FROM DSS) TO SOFTWARE USER
                if ($this->userType == self::DSS_USER_TYPE_SOFTWARE) {
                    $createdLetter1Id = $this->createLetter($letter1Id, ['pid' => $this->patientId, 'md_list' => $recipientsList]);
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

        $letterId = $this->createLetter($letterId, ['pid' => $this->patientId, 'topatient' => $toPatient]);

        return $letterId;
    }

    public function deleteLetter($userId, $letterId, $parent = null, $type, $recipientId, $template = null)
    {
        if (!isset($letterId)) {
            return false;
        }

        $letter = $this->letter->find($letterId);
        $contacts = $this->generalHelper->getContactInfo(
            (($letter->topatient == "1") ? $letter->patientid : ''),
            $letter->md_list,
            $letter->md_referral_list,
            $letter->pat_referral_list
        );

        $totalContacts = count($contacts['patient']) + count($contacts['mds']) + count($contacts['md_referrals']) + count($contacts['pat_referrals']);

        if ($totalContacts == 1) {
            $data = [
                'parentid'   => null,
                'deleted'    => 1,
                'deleted_by' => $userId,
                'deleted_on' => Carbon::now()
            ];
            $updatedLetter = $this->letter->updateLetterBy(['letterid' => $letterId], $data);

            $data = ['viewed' => 1];
            $this->fax->updateByLetterId($letterId, $data);

            $data = ['parentid' => null];
            $this->letter->updateLetterBy(['parentid' => $letterId], $data);

            return $updatedLetter;
        } else {
            if ($letter) {
                $deleted = '1';

                if ($type == 'patient') {
                    $toPatient = 1;
                    $removePatient = 0;
                } elseif ($type == 'md') {
                    $mdList = $recipientId;
                    $mds = explode(",", $letter->md_list);
                    $key = array_search($recipientId, $mds);

                    unset($mds[$key]);

                    $newMds = implode(",", $mds);
                    $ccMds = explode(",", $letter->cc_md_list);
                    $ccKey = array_search($recipientId, $ccMds);

                    unset($cc_mds[$cc_key]);

                    $newCcMds = implode(",", $ccMds);
                } elseif ($type == 'md_referral') {
                    $mdReferralList = $recipientId;
                    $mdReferrals = explode(",", $letter->md_referral_list);
                    $key = array_search($recipientId, $mdReferrals);

                    unset($mdReferrals[$key]);

                    $newMdReferrals = implode(",", $mdReferrals);
                    $ccMdReferrals = explode(",", $letter->cc_md_referral_list);
                    $ccKey = array_search($recipientId, $ccMdReferrals);

                    unset($ccMdReferrals[$ccKey]);

                    $newCcMdReferrals = implode(",", $ccMdReferrals);
                } elseif ($type == 'pat_referral') {
                    $patReferralList = $recipientId;
                    $patReferrals = explode(",", $letter->pat_referral_list);
                    $key = array_search($recipientId, $patReferrals);

                    unset($patReferrals[$key]);

                    $newPatReferrals = implode(",", $patReferrals);
                    $ccPatReferrals = explode(",", $letter->cc_pat_referral_list);
                    $ccKey = array_search($recipientId, $ccPatReferrals);

                    unset($ccPatReferrals[$ccKey]);

                    $newCcPatReferrals = implode(",", $ccPatReferrals);
                }

                $newLetterId = $this->createLetter($letter->templateid, $letter->patientid, $letter->info_id, $toPatient, $mdList, $mdReferralList, $patReferralList, $letterId, $template, $letter->send_method, '', $deleted, false);
            }

            if (is_numeric($newLetterId)) {
                if ($type == 'patient') {
                    $data = [
                        'topatient'    => $removePatient,
                        'cc_topatient' => $removePatient
                    ];
                } elseif ($type == 'md') {
                    $data = [
                        'md_list'    => $newMds,
                        'cc_md_list' => $newCcMds
                    ];
                } elseif ($type == 'md_referral') {
                    $data = [
                        'md_referral_list'    => $newMdReferrals,
                        'cc_md_referral_list' => $newCcMdReferrals
                    ];
                } elseif ($type == 'pat_referral') {
                    $data = [
                        'pat_referral_list'    => $newPatReferrals,
                        'cc_pat_referral_list' => $newCcPatReferrals
                    ];
                }

                $updateLetter = $this->letter->updateLetterBy(['letterid' => $letterId], $data);

                if (!$updateLetter) {
                    return false;
                } else {
                    return $newLetterId;
                }
            }
        }
    }

    private function createLetter($templateId, $args = []) {
        $defaultArgs = [
            'pid'                  => null,
            'info_id'              => null,
            'topatient'            => null,
            'md_list'              => null,
            'md_referral_list'     => null,
            'pat_referral_list'    => null,
            'parentid'             => null,
            'template'             => null,
            'send_method'          => null,
            'status'               => null,
            'deleted'              => null,
            'check_recipient'      => true,
            'template_type'        => null,
            'cc_topatient'         => null,
            'cc_md_list'           => null,
            'cc_md_referral_list'  => null,
            'cc_pat_referral_list' => null,
            'font_size'            => null,
            'font_family'          => null
        ];

        $args = array_merge($defaultArgs, $args);

        if ($this->docId > 0) {
            $foundUsers = $this->user->getWithFilter(['use_letters'], [
                'userid' => $this->docId
            ]);

            $doctor = count($foundUsers) ? $foundUsers[0] : null;

            if (!empty($doctor) && $doctor->use_letters != 1) {
                return -1;
            }
        }

        if ((empty($args['topatient']) && empty($args['md_referral_list']) && empty($args['md_list']) && empty($args['patient_referral_list']) ||
            ($args['check_recipient'] && empty($args['md_referral_list']) && empty($args['md_list']) &&
            ($templateId == 16 || $templateId == 19)))
        ) {
            return false;
        }

        //To remove referral source from md list if exists
        $mdArray = explode(',', $args['md_list']);

        if(($key = array_search($args['md_referral_list'], $mdArray)) !== false) {
            unset($mdArray[$key]);
        }

        $args['md_list'] = implode(',', $mdArray);
        $args['user_id'] = $this->userId;
        $args['doc_id'] = $this->docId;

        $createdLetter = $this->letter->createLetter($args);

        if ($createdLetter) {
            return $createdLetter->letterid;
        } else {
            return 0;
        }
    }
}
