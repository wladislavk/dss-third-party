<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Letter;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\Contact;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Structs\LetterData;

class LetterTriggerCollection
{
    const LETTER_TO_MD_FROM_DSS = 1;
    const LETTER_TO_MD_FROM_FRANCHISEE = 2;
    const LETTER_TO_PATIENT = 3;

    // TODO: why is this ID special? this information should be transferred to config or database
    const TREATMENT_COMPLETE_TEMPLATE_ID = 20;

    const TREATMENT_COMPLETE_FIELDS = [
        'referred_source',
        'docsleep',
        'docpcp',
        'docdentist',
        'docent',
        'docmdother',
        'docmdother2',
        'docmdother3',
    ];

    /** @var LetterCreator */
    private $letterCreator;

    /** @var Letter */
    private $letterModel;

    /** @var Patient */
    private $patientModel;

    /** @var User */
    private $userModel;

    /** @var Contact */
    private $contactModel;

    public function __construct(
        LetterCreator $letterCreator,
        Letter $letter,
        Patient $patient,
        User $user,
        Contact $contact
    ) {
        $this->letterCreator = $letterCreator;
        $this->letterModel = $letter;
        $this->patientModel = $patient;
        $this->userModel = $user;
        $this->contactModel = $contact;
    }

    /**
     * @param int $patientId
     * @param int $docId
     * @param int $userId
     */
    public function triggerPatientTreatmentComplete($patientId, $docId, $userId)
    {
        if ($patientId) {
            $where = ['patientid' => $patientId];
            $foundPatients = $this->patientModel->getWithFilter(self::TREATMENT_COMPLETE_FIELDS, $where);
        }

        $currentPatient = null;
        if (isset($foundPatients[0])) {
            $currentPatient = $foundPatients[0];
        }
        $patientReferralIds = $this->patientModel->getPatientReferralIds($patientId, $currentPatient);

        if (!$patientReferralIds) {
            return;
        }
        $letters = $this->letterModel->getPatientTreatmentComplete($patientId, $patientReferralIds);
        if (!count($letters)) {
            $letterData = new LetterData();
            $letterData->patientId = $patientId;
            $letterData->patientReferralList = $patientReferralIds;
            $templateId = self::TREATMENT_COMPLETE_TEMPLATE_ID;
            $this->letterCreator->createLetter($templateId, $letterData, $docId, $userId);
        }
    }

    /**
     * @param array $mdContacts
     * @param int $docId
     * @param int $userType
     * @param int $patientId
     * @param int $userId
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
        if (
            empty($userLetterInfo)
            ||
            !$userLetterInfo->use_letters
            ||
            !$userLetterInfo->intro_letters
        ) {
            return;
        }

        $recipients = [];
        foreach ($mdContacts as $contact) {
            if ($contact <= 0) {
                continue;
            }
            $mdLists = $this->letterModel->getMdList($contact, self::LETTER_TO_MD_FROM_DSS, self::LETTER_TO_MD_FROM_FRANCHISEE);

            if (!count($mdLists)) {
                continue;
            }
            $foundContact = $this->contactModel->getActiveContact($contact);

            if (!empty($foundContact)) {
                $recipients[] = $contact;
            }
        }

        if (count($recipients)) {
            $recipientsList = implode(',', $recipients);

            $letterData = new LetterData();
            $letterData->patientId = $patientId;
            $letterData->mdList = $recipientsList;
            $this->letterCreator->createLetter(self::LETTER_TO_MD_FROM_FRANCHISEE, $letterData, $docId, $userId);

            // TODO: the comment below looks misleading
            //DO NOT SENT LETTER 1 (FROM DSS) TO SOFTWARE USER
            if ($userType == MailerDataRetriever::DSS_USER_TYPE_SOFTWARE) {
                $this->letterCreator->createLetter(self::LETTER_TO_MD_FROM_DSS, $letterData, $docId, $userId);
            }
        }
    }

    /**
     * @param int $patientId
     * @param int $docId
     * @param int $userId
     */
    public function triggerIntroLetterToPatient($patientId, $docId, $userId)
    {
        $letterData = new LetterData();
        $letterData->patientId = $patientId;
        $letterData->toPatient = true;
        $this->letterCreator->createLetter(self::LETTER_TO_PATIENT, $letterData, $docId, $userId);
    }
}
