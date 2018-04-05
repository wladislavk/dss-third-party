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
    /** @var SummaryLetterDataUpdater */
    private $summaryLetterDataUpdater;

    /** @var UserRepository */
    private $userRepository;

    /** @var AppointmentSummaryRepository */
    private $appointmentSummaryRepository;

    /** @var DBChangeWrapper */
    private $dbChangeWrapper;

    public function __construct(
        SummaryLetterDataUpdater $summaryLetterDataUpdater,
        UserRepository $userRepository,
        AppointmentSummaryRepository $appointmentSummaryRepository,
        DBChangeWrapper $dbChangeWrapper
    ) {
        $this->summaryLetterDataUpdater = $summaryLetterDataUpdater;
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
        $stepId = $tableElement[SummaryLetterTable::STEP_ID_COLUMN];
        if (!$this->doesDocUseLetters($data->docId) || !$this->isStepCompleted($stepId, $data->patientId)) {
            return;
        }
        $this->summaryLetterDataUpdater->completeSummaryLetterData($data, $tableElement);
        if (!$data->toPatient && !sizeof($data->mdReferralList) && !sizeof($data->mdList)) {
            return;
        }
        $newLetter = $this->createLetter($data);
        $this->dbChangeWrapper->save($newLetter);
    }

    /**
     * @param int $docId
     * @return bool
     * @throws RepositoryException
     */
    private function doesDocUseLetters(int $docId): bool
    {
        if (!$docId) {
            return true;
        }
        /** @var User|null $docUser */
        $docUser = $this->userRepository->findOrNull($docId);
        if ($docUser && $docUser->use_letters == 1) {
            return true;
        }
        return false;
    }

    /**
     * @param int $stepId
     * @param int $patientId
     * @return bool
     */
    private function isStepCompleted(int $stepId, int $patientId): bool
    {
        if (!$stepId) {
            return true;
        }
        $completedRows = $this->appointmentSummaryRepository->getCompletedByPatient($stepId, $patientId);
        if ($completedRows) {
            return true;
        }
        return false;
    }

    /**
     * @param SummaryLetterTriggerData $data
     * @return Letter
     */
    private function createLetter (SummaryLetterTriggerData $data): Letter
    {
        $mdListString = implode(',', $data->mdList);
        $mdReferralListString = implode(',', $data->mdReferralList);
        $newLetter = new Letter();
        $newLetter->templateid = $data->letterId;
        $newLetter->patientid = $data->patientId;
        $newLetter->info_id = $data->infoId;
        $newLetter->topatient = (int)$data->toPatient;
        $newLetter->cc_topatient = (int)$data->toPatient;
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
}
