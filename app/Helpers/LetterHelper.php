<?php

namespace DentalSleepSolutions\Helpers;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Dental\Letter;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\Contact;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Eloquent\Dental\Fax;
use DentalSleepSolutions\Structs\LetterData;

class LetterHelper
{
    /** @var GeneralHelper */
    private $generalHelper;

    /** @var Letter */
    private $letterModel;

    /** @var Patient */
    private $patientModel;

    /** @var Contact */
    private $contactModel;

    /** @var User */
    private $userModel;

    /** @var Fax */
    private $faxModel;

    public function __construct(
        GeneralHelper $generalHelper,
        Letter $letter,
        Patient $patient,
        Contact $contact,
        User $user,
        Fax $fax
    ) {
        $this->generalHelper = $generalHelper;
        $this->letterModel = $letter;
        $this->patientModel = $patient;
        $this->contactModel = $contact;
        $this->userModel = $user;
        $this->faxModel = $fax;
    }

    /**
     * @param int $patientId
     * @param int $docId
     * @param int $userId
     * @return bool|int|mixed
     */
    public function triggerPatientTreatmentComplete($patientId, $docId, $userId)
    {
        if ($patientId) {
            $fields = [
                'referred_source',
                'docsleep',
                'docpcp',
                'docdentist',
                'docent',
                'docmdother',
                'docmdother2',
                'docmdother3',
            ];
            $where = ['patientid' => $patientId];
            $foundPatients = $this->patientModel->getWithFilter($fields, $where);
        }

        $currentPatient = null;
        if (isset($foundPatients[0])) {
            $currentPatient = $foundPatients[0];
        }
        $patientReferralIds = $this->patientModel->getPatientReferralIds($patientId, $currentPatient);

        $letterId = 0;
        if ($patientReferralIds) {
            $letters = $this->letterModel->getPatientTreatmentComplete($patientId, $patientReferralIds);
            if (!count($letters)) {
                $letterData = new LetterData();
                $letterData->patientId = $patientId;
                $letterData->patientReferralList = $patientReferralIds;
                $templateId = 20;
                $letterId = $this->createLetter($templateId, $letterData, $docId, $userId);
            }
        }
        return $letterId;
    }

    /**
     * @param array $mdContacts
     * @param int $docId
     * @param int $userType
     * @param int $patientId
     * @param int $userId
     * @return array|null
     */
    public function triggerIntroLettersToMDFromDSSAndFranchisee(array $mdContacts, $docId, $userType, $patientId, $userId)
    {
        $baseUserLetterInfo = $this->userModel->getWithFilter(
            ['use_letters', 'intro_letters'],
            ['userid' => $docId]
        );

        $userLetterInfo = null;
        if (isset($baseUserLetterInfo[0])) {
            $userLetterInfo = $baseUserLetterInfo[0];
        }

        $data = null;
        if (!empty($userLetterInfo) && $userLetterInfo->use_letters && $userLetterInfo->intro_letters) {
            $letter1Id = 1;
            $letter2Id = 2;

            $recipients = [];
            foreach ($mdContacts as $contact) {
                if ($contact <= 0) {
                    continue;
                }
                $mdLists = $this->letterModel->getMdList($contact, $letter1Id, $letter2Id);

                if (!count($mdLists)) {
                    continue;
                }
                $foundContact = $this->contactModel->getActiveContact($contact);

                if (!empty($foundContact)) {
                    $recipients[] = $contact;
                }
            }

            $createdLetter1Id = 0;
            $createdLetter2Id = 0;

            if (count($recipients)) {
                $recipientsList = implode(',', $recipients);

                $letterData = new LetterData();
                $letterData->patientId = $patientId;
                $letterData->mdList = $recipientsList;
                $createdLetter2Id = $this->createLetter($letter2Id, $letterData, $docId, $userId);

                //DO NOT SENT LETTER 1 (FROM DSS) TO SOFTWARE USER
                if ($userType == MailerDataRetriever::DSS_USER_TYPE_SOFTWARE) {
                    $createdLetter1Id = $this->createLetter($letter1Id, $letterData, $docId, $userId);
                }
            }

            $data = [
                'letter_1_id' => $createdLetter1Id,
                'letter_2_id' => $createdLetter2Id
            ];
        }

        return $data;
    }

    /**
     * @param int $patientId
     * @param int $docId
     * @param int $userId
     * @return bool|int|mixed
     */
    public function triggerIntroLetterToPatient($patientId, $docId, $userId)
    {
        $letterId = 3;

        $letterData = new LetterData();
        $letterData->patientId = $patientId;
        $letterData->toPatient = true;
        $letterId = $this->createLetter($letterId, $letterData, $docId, $userId);

        return $letterId;
    }

    /**
     * TODO: check why we need the last argument
     *
     * @param int $letterId
     * @param $type
     * @param int $recipientId
     * @param int $docId
     * @param int $userId
     * @param null $template
     * @return bool|int|mixed
     */
    public function deleteLetter($letterId, $type, $recipientId, $docId, $userId, $template = null)
    {
        if ($letterId <= 0) {
            return false;
        }

        /** @var Letter|null $letter */
        $letter = $this->letterModel->find($letterId);

        if (!$letter) {
            return false;
        }

        $patientId = 0;
        if ($letter->topatient) {
            $patientId = $letter->patientid;
        }
        $contacts = $this->generalHelper->getContactInfo(
            $patientId,
            $letter->md_list,
            $letter->md_referral_list,
            $letter->pat_referral_list
        );

        $totalContacts =
            count($contacts->getPatients())
            +
            count($contacts->getMds())
            +
            count($contacts->getMdReferrals())
            +
            count($contacts->getPatientReferrals())
        ;

        if ($totalContacts == 1) {
            $where = ['letterid' => $letterId];
            $updatedFields = ['parentid', 'deleted', 'deleted_by', 'deleted_on'];
            $data = new LetterData();
            $data->deleted = true;
            $data->deletedBy = $userId;
            $data->deletedOn = Carbon::now();

            $updatedLetter = $this->letterModel->updateLetterBy($where, $data, $updatedFields);

            $data = ['viewed' => 1];
            $this->faxModel->updateByLetterId($letterId, $data);

            $where = ['parentid' => $letterId];
            $updatedFields = ['parentid'];
            $data = new LetterData();
            $this->letterModel->updateLetterBy($where, $data, $updatedFields);

            return $updatedLetter;
        }
        $newLetterData = new LetterData();
        $newLetterData->deleted = true;

        $dataForUpdate = new LetterData();
        $updatedFields = [];
        switch ($type) {
            // TODO: first two types are never used, check if needed
            case 'patient':
                $newLetterData->toPatient = true;

                $dataForUpdate->toPatient = false;
                $dataForUpdate->ccToPatient = false;
                $updatedFields = ['topatient', 'cc_topatient'];
                break;
            case 'md':
                $newLetterData->mdList = $recipientId;

                $mds = array_diff(explode(',', $letter->md_list), [$recipientId]);
                $ccMds = array_diff(explode(',', $letter->cc_md_list), [$recipientId]);

                $updatedFields = ['md_list', 'cc_md_list'];
                $dataForUpdate->mdList = implode(',', $mds);
                $dataForUpdate->ccMdList = implode(',', $ccMds);
                break;
            case 'md_referral':
                $newLetterData->mdReferralList = $recipientId;

                $mdReferrals = array_diff(explode(',', $letter->md_referral_list), [$recipientId]);
                $ccMdReferrals = array_diff(explode(',', $letter->cc_md_referral_list), [$recipientId]);

                $updatedFields = ['md_referral_list', 'cc_md_referral_list'];
                $dataForUpdate->mdReferralList = implode(',', $mdReferrals);
                $dataForUpdate->ccMdReferralList = implode(',', $ccMdReferrals);
                break;
            case 'pat_referral':
                $newLetterData->patientReferralList = $recipientId;

                $patReferrals = array_diff(explode(',', $letter->pat_referral_list), [$recipientId]);
                $ccPatReferrals = array_diff(explode(',', $letter->cc_pat_referral_list), [$recipientId]);

                $updatedFields = ['pat_referral_list', 'cc_pat_referral_list'];
                $dataForUpdate->patientReferralList = implode(',', $patReferrals);
                $dataForUpdate->ccPatientReferralList = implode(',', $ccPatReferrals);
                break;
        }

        $newLetterData->patientId = $letter->patientid;
        $newLetterData->infoId = $letter->info_id;
        $newLetterData->parentId = $letterId;
        $newLetterData->template = $template;
        $newLetterData->sendMethod = $letter->send_method;
        $newLetterData->status = false;
        $newLetterData->checkRecipient = false;

        $newLetterId = $this->createLetter($letter->templateid, $newLetterData, $docId, $userId);

        if ($newLetterId > 0) {
            $where = ['letterid' => $letterId];
            $updateLetter = $this->letterModel->updateLetterBy($where, $dataForUpdate, $updatedFields);

            if (!$updateLetter) {
                return false;
            }
            return $newLetterId;
        }
        return false;
    }

    /**
     * @param int $templateId
     * @param LetterData $letterData
     * @param int $docId
     * @param int $userId
     * @return bool
     */
    private function createLetter($templateId, LetterData $letterData, $docId, $userId) {
        if ($docId > 0) {
            $foundUsers = $this->userModel->getWithFilter(
                ['use_letters'],
                ['userid' => $docId]
            );

            $doctor = null;
            if (isset($foundUsers[0])) {
                $doctor = $foundUsers[0];
            }

            if (!empty($doctor) && $doctor->use_letters != 1) {
                return -1;
            }
        }

        if (
            empty($letterData->toPatient) && empty($letterData->mdReferralList) && empty($letterData->mdList) && empty($letterData->patientReferralList)
                ||
            ($letterData->checkRecipient && empty($letterData->mdReferralList) && empty($letterData->mdList) && ($templateId == 16 || $templateId == 19))
        ) {
            return 0;
        }

        //To remove referral source from md list if exists
        $mdArray = explode(',', $letterData->mdList);

        if (($key = array_search($letterData->mdReferralList, $mdArray)) !== false) {
            unset($mdArray[$key]);
        }

        $letterData->mdList = implode(',', $mdArray);
        $letterData->userId = $userId;
        $letterData->docId = $docId;

        $createdLetter = $this->letterModel->createLetter($letterData);

        if ($createdLetter) {
            return $createdLetter->letterid;
        }
        return 0;
    }
}
