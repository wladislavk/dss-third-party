<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Constants\SummaryLetterTable;
use DentalSleepSolutions\Structs\SummaryLetterTriggerData;

class SummaryLetterDataUpdater
{
    /** @var DoctorIDRetriever */
    private $doctorIDRetriever;

    public function __construct(DoctorIDRetriever $doctorIDRetriever)
    {
        $this->doctorIDRetriever = $doctorIDRetriever;
    }

    /**
     * @param SummaryLetterTriggerData $data
     * @param array $tableElement
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function completeSummaryLetterData(SummaryLetterTriggerData $data, array $tableElement): void
    {
        $data->letterId = $this->getLetterId($tableElement);
        $data->toPatient = $this->isToPatient($tableElement);
        if ($this->hasMdList($tableElement)) {
            $data->mdList = $this->doctorIDRetriever->getMdContactIds($data->patientId);
        }
        if ($this->hasMdReferralList($tableElement)) {
            $data->mdReferralList = $this->doctorIDRetriever->getMdReferralIds($data->patientId);
        }
        $this->removeReferralSourceFromMDList($data);
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
     * @param array $tableElement
     * @return bool
     */
    private function hasMdList(array $tableElement): bool
    {
        return $tableElement[SummaryLetterTable::MD_LIST_COLUMN];
    }

    /**
     * @param array $tableElement
     * @return bool
     */
    private function hasMdReferralList(array $tableElement): bool
    {
        return $tableElement[SummaryLetterTable::MD_REFERRAL_LIST_COLUMN];
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
     * @param SummaryLetterTriggerData $data
     */
    private function removeReferralSourceFromMDList(SummaryLetterTriggerData $data): void
    {
        $data->mdList = array_filter($data->mdList, function (int $element) use ($data): bool {
            if (in_array($element, $data->mdReferralList)) {
                return false;
            }
            return true;
        });
        $data->mdList = array_values($data->mdList);
    }
}
