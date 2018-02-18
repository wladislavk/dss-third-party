<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\FlowsheetStepRepository;

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

    public function getRanksBySection()
    {
        return [
            'first' => $this->flowsheetStepRepository->getStepsByRank(1),
            'second' => $this->flowsheetStepRepository->getStepsByRank(2),
        ];
    }

    public function getFinalRank($patientId)
    {
        $steps = $this->appointmentSummaryRepository->getLastTrackerStep($patientId);
        $lastSegment = null;
        $finalSegment = null;
        $finalRank = 0;
        if (!sizeof($steps)) {
            return [
                'last_segment' => $lastSegment,
                'final_segment' => $finalSegment,
                'final_rank' => $finalRank,
            ];
        }
        $lastStep = $steps[0];
        $lastSegment = $lastStep['segmentid'];
        if ($lastStep['section'] == 1) {
            $steps = array_filter($steps, function (array $element) {
                if ($element['section'] == 1) {
                    return true;
                }
                return false;
            });
        }
        if (sizeof($steps)) {
            usort($steps, function (array $a, array $b) {
                if ($a['section'] > $b['section']) {
                    return -1;
                }
                if ($a['section'] < $b['section']) {
                    return 1;
                }
                if ($a['sort_by'] > $b['sort_by']) {
                    return -1;
                }
                return 1;
            });
            $finalStep = $steps[0];
            $ranks = $this->flowsheetStepRepository->getStepsByRank();
            foreach ($ranks as $rank) {
                if ($finalStep['segmentid'] == $rank['id']) {
                    $finalRank = $rank['rank'];
                }
            }
            $finalSegment = $finalStep['segmentid'];
        }
        return [
            'last_segment' => $lastSegment,
            'final_segment' => $finalSegment,
            'final_rank' => $finalRank,
        ];
    }
}
