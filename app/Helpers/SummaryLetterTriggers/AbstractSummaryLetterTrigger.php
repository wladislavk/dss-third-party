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
use DentalSleepSolutions\Structs\SummaryLetterTriggerData;

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
     * @param SummaryLetterTriggerData $data
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function triggerLetter(SummaryLetterTriggerData $data): void
    {
        $mdList = '';
        if ($this->hasMdList()) {
            $mdList = $this->getMdContactIds($data->patientId);
        }
        $mdReferralList = '';
        if ($this->hasMdReferralList()) {
            $mdReferralList = $this->getMdReferralIds($data->patientId);
        }
        $this->createLetter(
            $data,
            $this->getLetterId(),
            $this->isToPatient(),
            $mdList,
            $mdReferralList
        );
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
     * @param SummaryLetterTriggerData $data
     * @param int $templateId
     * @param bool $toPatient
     * @param string $mdList
     * @param string $mdReferralList
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    private function createLetter (
        SummaryLetterTriggerData $data,
        int $templateId,
        bool $toPatient,
        string $mdList,
        string $mdReferralList
    ): void {
        if ($data->docId) {
            /** @var User|null $user */
            $user = $this->userRepository->findOrNull($data->docId);
            if ($user->use_letters != 1) {
                return;
            }
        }
        if (!$toPatient && !$mdReferralList && !$mdList) {
            return;
        }
        //To remove referral source from md list if exists
        $mdArray = explode(',', $mdList);

        $mdArray = array_filter($mdArray, function ($element) use ($mdReferralList) {
            return $element != $mdReferralList;
        });
        $mdList = implode(',', $mdArray);

        $newLetter = new Letter();
        $newLetter->templateid = $templateId;
        $newLetter->patientid = $data->patientId;
        $newLetter->info_id = $data->infoId;
        $newLetter->topatient = $toPatient;
        $newLetter->cc_topatient = $toPatient;
        $newLetter->md_list = $mdList;
        $newLetter->cc_md_list = $mdList;
        $newLetter->md_referral_list = $mdReferralList;
        $newLetter->cc_md_referral_list = $mdReferralList;
        $newLetter->status = 0;
        $newLetter->deleted = 0;
        $newLetter->deleted_on = new \DateTime();
        $newLetter->deleted_by = $data->userId;
        $newLetter->generated_date = new \DateTime();
        $newLetter->delivered = 0;
        $newLetter->docid = $data->docId;
        $newLetter->userid = $data->userId;
        $newLetter->save();
    }
}
