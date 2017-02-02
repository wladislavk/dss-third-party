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
    private $userId;

    public function __construct(
        Letter $letter,
        Patient $patient,
        Contact $contact,
        User $user,
        Fax $fax,
        GeneralHelper $generalHelper,
        $docId = 0,
        $patientId = 0,
        $userType = 0,
        $userId = 0
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
        $this->userId = $userId;
    }

    public function setIdentificators($docId, $patientId, $userType, $userId)
    {
        $this->docId = $docId;
        $this->patientId = $patientId;
        $this->userType = $userType;
        $this->userId = $userId;
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

    public function deleteLetter($letterId, $parent = null, $type, $recipientId, $template = null)
    {
        if ($letterId <= 0) {
            return false;
        }

        $letter = $this->letter->find($letterId);

        if (empty($letter)) {
            return false;
        }

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
                'deleted_by' => $this->userId,
                'deleted_on' => Carbon::now()
            ];

            $updatedLetter = $this->letter->updateLetterBy(['letterid' => $letterId], $data);

            $data = ['viewed' => 1];
            $this->fax->updateByLetterId($letterId, $data);

            $data = ['parentid' => null];
            $this->letter->updateLetterBy(['parentid' => $letterId], $data);

            return $updatedLetter;
        } else {
            $args = ['deleted' => 1];

            if ($type == 'patient') {
                $args['topatient'] = 1;

                $dataForUpdate = [
                    'topatient'    => 0,
                    'cc_topatient' => 0
                ];
            } elseif ($type == 'md') {
                $args['md_list'] = $recipientId;

                $mds = array_diff(explode(',', $letter->md_list), [$recipientId]);
                $ccMds = array_diff(explode(',', $letter->cc_md_list), [$recipientId]);

                $dataForUpdate = [
                    'md_list'    => implode(',', $mds),
                    'cc_md_list' => implode(',', $ccMds)
                ];
            } elseif ($type == 'md_referral') {
                $args['md_referral_list'] = $recipientId;

                $mdReferrals = array_diff(explode(',', $letter->md_referral_list), [$recipientId]);
                $ccMdReferrals = array_diff(explode(',', $letter->cc_md_referral_list), [$recipientId]);

                $dataForUpdate = [
                    'md_referral_list'    => implode(',', $mdReferrals),
                    'cc_md_referral_list' => implode(',', $ccMdReferrals)
                ];
            } elseif ($type == 'pat_referral') {
                $args['pat_referral_list'] = $recipientId;

                $patReferrals = array_diff(explode(',', $letter->pat_referral_list), [$recipientId]);
                $ccPatReferrals = array_diff(explode(',', $letter->cc_pat_referral_list), [$recipientId]);

                $dataForUpdate = [
                    'pat_referral_list'    => implode(',', $patReferrals),
                    'cc_pat_referral_list' => implode(',', $ccPatReferrals)
                ];
            }

            $args = array_merge($args, [
                'pid'             => $letter->patientid,
                'info_id'         => $letter->info_id,
                'parentid'        => $letterId,
                'template'        => $template,
                'send_method'     => $letter->send_method,
                'status'          => '',
                'check_recipient' => false
            ]);

            $newLetterId = $this->createLetter($letter->templateid, $args);

            if ($newLetterId > 0) {
                $updateLetter = $this->letter->updateLetterBy(['letterid' => $letterId], $dataForUpdate);

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
