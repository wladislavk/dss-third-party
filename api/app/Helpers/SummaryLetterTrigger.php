<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Constants\SummaryLetterTable;
use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Structs\SummaryLetterTriggerData;
use DentalSleepSolutions\Wrappers\DBChangeWrapper;
use Prettus\Repository\Exceptions\RepositoryException;

class SummaryLetterTrigger
{
    /** @var DoctorIDRetriever */
    private $doctorIDRetriever;

    /** @var UserRepository */
    private $userRepository;

    /** @var AppointmentSummaryRepository */
    private $appointmentSummaryRepository;

    /** @var DBChangeWrapper */
    private $dbChangeWrapper;

    public function __construct(
        DoctorIDRetriever $doctorIDRetriever,
        UserRepository $userRepository,
        AppointmentSummaryRepository $appointmentSummaryRepository,
        DBChangeWrapper $dbChangeWrapper
    ) {
        $this->doctorIDRetriever = $doctorIDRetriever;
        $this->userRepository = $userRepository;
        $this->appointmentSummaryRepository = $appointmentSummaryRepository;
        $this->dbChangeWrapper = $dbChangeWrapper;
    }

    /**
     * @param SummaryLetterTriggerData $data
     * @param array $tableElement
     * @throws RepositoryException
     */
    public function triggerLetter(SummaryLetterTriggerData $data, array $tableElement): void
    {
        if ($data->docId) {
            /** @var User|null $docUser */
            $docUser = $this->userRepository->findOrNull($data->docId);
            if ($docUser->use_letters != 1) {
                return;
            }
        }
        if ($tableElement[SummaryLetterTable::STEP_ID_COLUMN]) {
            $completedRows = $this->appointmentSummaryRepository
                ->getCompletedByPatient($tableElement[SummaryLetterTable::STEP_ID_COLUMN], $data->patientId);
            if (!$completedRows) {
                return;
            }
        }
        $data->toPatient = $this->isToPatient($tableElement);
        $mdList = [];
        if ($tableElement[SummaryLetterTable::MD_LIST_COLUMN]) {
            $mdList = $this->doctorIDRetriever->getMdContactIds($data->patientId);
        }
        $mdReferralList = [];
        if ($tableElement[SummaryLetterTable::MD_REFERRAL_LIST_COLUMN]) {
            $mdReferralList = $this->doctorIDRetriever->getMdReferralIds($data->patientId);
        }
        if (!$data->toPatient && !$mdReferralList && !$mdList) {
            return;
        }
        $mdList = $this->removeReferralSourceFromMDList($mdList, $mdReferralList);
        $data->letterId = $this->getLetterId($tableElement);
        $newLetter = $this->createLetter($data, $mdList, $mdReferralList);
        $this->dbChangeWrapper->save($newLetter);
    }

    /**
     * @param array $tableElement
     * @return int
     */
    private function getLetterId(array $tableElement): int
    {
        return $tableElement[SummaryLetterTable::LETTER_ID_COLUMN];
    }

    /**
     * @param array $tableElement
     * @return bool
     */
    private function isToPatient(array $tableElement): bool
    {
        return $tableElement[SummaryLetterTable::TO_PATIENT_COLUMN];
    }

    /**
     * @param SummaryLetterTriggerData $data
     * @param int[] $mdList
     * @param int[] $mdReferralList
     * @return Letter
     */
    private function createLetter (
        SummaryLetterTriggerData $data,
        array $mdList,
        array $mdReferralList
    ): Letter {
        $mdListString = implode(',', $mdList);
        $mdReferralListString = implode(',', $mdReferralList);

        $newLetter = new Letter();
        $newLetter->templateid = $data->letterId;
        $newLetter->patientid = $data->patientId;
        $newLetter->info_id = $data->infoId;
        $newLetter->topatient = $data->toPatient;
        $newLetter->cc_topatient = $data->toPatient;
        $newLetter->md_list = $mdListString;
        $newLetter->cc_md_list = $mdListString;
        $newLetter->md_referral_list = $mdReferralListString;
        $newLetter->cc_md_referral_list = $mdReferralListString;
        $newLetter->status = 0;
        $newLetter->deleted = 0;
        $newLetter->deleted_on = new \DateTime();
        $newLetter->deleted_by = $data->userId;
        $newLetter->generated_date = new \DateTime();
        $newLetter->delivered = 0;
        $newLetter->docid = $data->docId;
        $newLetter->userid = $data->userId;
        return $newLetter;
    }

    /**
     * @param int[] $mdList
     * @param int[] $mdReferralList
     * @return int[]
     */
    private function removeReferralSourceFromMDList(array $mdList, array $mdReferralList): array
    {
        $mdList = array_filter($mdList, function (int $element) use ($mdReferralList): bool {
            if (in_array($element, $mdReferralList)) {
                return false;
            }
            return true;
        });
        return $mdList;
    }
}
