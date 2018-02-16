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
        $finalRank = 0;
        if (sizeof($steps)) {
            $lastStep = $steps[sizeof($steps) - 1];
            if ($lastStep['sectionid' == 1]) {
                $steps = array_filter($steps, function (array $element) {
                    if ($element['info.section'] == 1) {
                        return true;
                    }
                    return false;
                });
            }
        }
        if (sizeof($steps)) {
            usort($steps, function (array $a, array $b) {
                if ($a['steps.section'] > $b['steps.section']) {
                    return -1;
                }
                if ($a['steps.section'] < $b['steps.section']) {
                    return 1;
                }
                if ($a['steps.sort_by'] > $b['steps.sort_by']) {
                    return -1;
                }
                return 1;
            });
            $finalStep = $steps[sizeof($steps) - 1];
            $ranks = $this->flowsheetStepRepository->getStepsByRank();
            foreach ($ranks as $rank) {
                if ($finalStep['segmentid'] == $rank['id']) {
                    $finalRank = $rank['rank'];
                }
            }
        }
        return $finalRank;
        /*
$sched_sql = "SELECT * FROM dental_flow_pg2_info WHERE appointment_type=0 and patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
$sched_r = $db->getRow($sched_sql);

$next_sql = "SELECT steps.* FROM dental_flowsheet_steps steps
JOIN dental_flowsheet_steps_next next ON steps.id = next.child_id
WHERE next.parent_id='".mysqli_real_escape_string($con,$last['segmentid'])."'
ORDER BY next.sort_by ASC";
$next_q = $db->getResults($next_sql);
 */
    }
}
