<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

// @todo: unite this class into a single hierarchy with AbstractLetterTrigger
use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Helpers\IdListCleaner;

abstract class AbstractSummaryLetterTrigger
{
    /** @var IdListCleaner */
    private $idListCleaner;

    /** @var PatientRepository */
    private $patientRepository;

    /** @var ContactRepository */
    private $contactRepository;

    /** @var UserRepository */
    private $userRepository;

    public function __construct(
        IdListCleaner $idListCleaner,
        PatientRepository $patientRepository,
        ContactRepository $contactRepository,
        UserRepository $userRepository
    ) {
        $this->idListCleaner = $idListCleaner;
        $this->patientRepository = $patientRepository;
        $this->contactRepository = $contactRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $patientId
     * @param int $infoId
     * @param int $userId
     * @param int $docId
     * @return int|null|string
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function triggerLetter($patientId, $infoId, $userId, $docId)
    {
        $mdList = '';
        if ($this->hasMdList()) {
            $mdList = $this->getMdContactIds($patientId);
        }
        $mdReferralList = '';
        if ($this->hasMdReferralList()) {
            $mdReferralList = $this->getMdReferralIds($patientId);
        }
        $letter = $this->createLetter(
            $this->getLetterId(),
            $patientId,
            $infoId,
            $this->isToPatient(),
            $mdList,
            $mdReferralList,
            $userId,
            $docId
        );
        if (is_numeric($letter)) {
            return $letter;
        }
        return null;
    }

    /**
     * @return int
     */
    abstract protected function getLetterId();

    /**
     * @return bool
     */
    abstract protected function isToPatient();

    /**
     * @return bool
     */
    abstract protected function hasMdList();

    /**
     * @return bool
     */
    abstract protected function hasMdReferralList();

    /**
     * @param int $patientId
     * @param bool $active
     * @return array|null
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    private function getMdContactIds($patientId, $active = true)
    {
        /** @var Patient|null $contact */
        $contact = $this->patientRepository->findOrNull($patientId);
        if (!$contact) {
            return null;
        }
        $contactIds = [];
        foreach ($contact->toArray() as $field) {
            if ($field == "Not Set") {
                continue;
            }
            $contacts = explode(",", $field);
            foreach ($contacts as $contactId) {
                if ($contactId && !in_array($contactId, $contactIds)) {
                    if ($active) {
                        /** @var Contact|null $contact */
                        $contact = $this->contactRepository->findOrNull($contactId);
                        if ($contact->status == 1) {
                            $contactIds[] = $contact;
                        }
                    } else {
                        $contactIds[] = $contactId;
                    }
                }
            }
        }
        $contactIdList = $this->idListCleaner->clearIdList(implode(",", $contactIds));
        return $contactIdList;
    }

    /**
     * @param int $patientId
     * @param bool $active
     * @return null|string|string[]
     */
    private function getMdReferralIds($patientId, $active = true)
    {
        $contactResult = $this->contactRepository->getReferralIds($patientId);
        $contactIds = [];

        foreach ($contactResult as $element) {
            $contactId = $element['dental_contact.contactid'];
            if (!in_array($contactId, $contactIds)) {
                if ($active) {
                    if ($element['dental_contact.status'] == 1) {
                        $contactIds[] = $contactId;
                    }
                } else {
                    $contactIds[] = $contactId;
                }
            }
        }

        $contactIdList = $this->idListCleaner->clearIdList(implode(",", $contactIds));
        return $contactIdList;
    }

    /**
     * @param int $templateId
     * @param int $patientId
     * @param int $infoId
     * @param bool $toPatient
     * @param string $mdList
     * @param string $mdReferralList
     * @param int $userId
     * @param int $docId
     * @return int
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    private function createLetter (
        $templateId,
        $patientId,
        $infoId,
        $toPatient,
        $mdList,
        $mdReferralList,
        $userId,
        $docId
    ) {
        if ($docId) {
            /** @var User|null $user */
            $user = $this->userRepository->findOrNull($docId);
            if ($user->use_letters != 1) {
                return -1;
            }
        }
        if (!$toPatient && !$mdReferralList && !$mdList) {
            return false;
        }
        //To remove referral source from md list if exists
        $mdArray = explode(',', $mdList);

        $mdArray = array_filter($mdArray, function ($element) use ($mdReferralList) {
            return $element != $mdReferralList;
        });
        $mdList = implode(',', $mdArray);

        $newLetter = new Letter();
        $newLetter->templateid = $templateId;
        $newLetter->patientid = $patientId;
        $newLetter->info_id = $infoId;
        $newLetter->topatient = $toPatient;
        $newLetter->cc_topatient = $toPatient;
        $newLetter->md_list = $mdList;
        $newLetter->cc_md_list = $mdList;
        $newLetter->md_referral_list = $mdReferralList;
        $newLetter->cc_md_referral_list = $mdReferralList;
        $newLetter->status = 0;
        $newLetter->deleted = 0;
        $newLetter->deleted_on = new \DateTime();
        $newLetter->deleted_by = $userId;
        $newLetter->generated_date = new \DateTime();
        $newLetter->delivered = 0;
        $newLetter->docid = $docId;
        $newLetter->userid = $userId;
        $newLetter->save();
        return $newLetter->letterid;
    }
}
