<?php

namespace DentalSleepSolutions\Services\AppointmentSummaries;

use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\FlowsheetStepRepository;
use DentalSleepSolutions\Structs\FinalRankData;

class TrackerStepRetriever
{
    /** @var AppointmentSummaryRepository */
    private $appointmentSummaryRepository;

    /** @var FlowsheetStepRepository */
    private $flowsheetStepRepository;

    public function __construct(
        AppointmentSummaryRepository $appointmentSummaryRepository,
        FlowsheetStepRepository $flowsheetStepRepository
    ) {
        $this->appointmentSummaryRepository = $appointmentSummaryRepository;
        $this->flowsheetStepRepository = $flowsheetStepRepository;
    }

    /**
     * @return array
     */
    public function getRanksBySection(): array
    {
        return [
            'first' => $this->flowsheetStepRepository->getStepsByRank(1),
            'second' => $this->flowsheetStepRepository->getStepsByRank(2),
        ];
    }

    /**
     * @param int $patientId
     * @return FinalRankData
     */
    public function getFinalRank(int $patientId): FinalRankData
    {
        $steps = $this->appointmentSummaryRepository->getLastTrackerStep($patientId);
        $finalRankData = new FinalRankData();
        if (!sizeof($steps)) {
            return $finalRankData;
        }
        $lastStep = $steps[0];
        $finalRankData->lastSegment = $lastStep['segmentid'];
        if ($lastStep['section'] == 1) {
            $steps = $this->getOnlyFirstSection($steps);
        }
        $steps = $this->compareStepsBySectionAndSortBy($steps);
        $finalStep = $steps[0];
        $finalSegmentId = $finalStep['segmentid'];
        $finalRankData->finalSegment = $finalSegmentId;
        $ranks = $this->flowsheetStepRepository->getStepsByRank();
        $finalRankData->finalRank = $this->retrieveFinalRankId($ranks, $finalSegmentId);
        return $finalRankData;
    }

    /**
     * @param array[] $steps
     * @return array[]
     */
    private function getOnlyFirstSection(array $steps): array
    {
        return array_filter($steps, function (array $element) {
            if ($element['section'] == 1) {
                return true;
            }
            return false;
        });
    }

    /**
     * @param array[] $ranks
     * @param int $finalSegmentId
     * @return int
     */
    private function retrieveFinalRankId(array $ranks, int $finalSegmentId)
    {
        foreach ($ranks as $rank) {
            if ($finalSegmentId == $rank['id']) {
                return $rank['rank'];
            }
        }
        return 0;
    }

    /**
     * @param array[] $steps
     * @return array[]
     */
    private function compareStepsBySectionAndSortBy(array $steps): array
    {
        usort($steps, function (array $a, array $b) {
            $sectionComparison = $b['section'] <=> $a['section'];
            if ($sectionComparison !== 0) {
                return $sectionComparison;
            }
            return $b['sort_by'] <=> $a['sort_by'];
        });
        return $steps;
    }
}
