<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;

class TrackerSectionRetriever
{
    /** @var AppointmentSummaryRepository */
    private $appointmentSummaryRepository;

    public function __construct(AppointmentSummaryRepository $appointmentSummaryRepository)
    {
        $this->appointmentSummaryRepository = $appointmentSummaryRepository;
    }

    public function sortTrackerSections()
    {
        /*
        $last_sql = "SELECT * FROM dental_flow_pg2_info info
JOIN dental_flowsheet_steps steps on info.segmentid = steps.id
WHERE (date_completed != '' AND date_completed IS NOT NULL) AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' ORDER BY date_completed DESC, info.id DESC";
        $last = $db->getRow($last_sql);

        $final_sql = "SELECT * FROM dental_flow_pg2_info info
  JOIN dental_flowsheet_steps steps on info.segmentid = steps.id
  WHERE (date_completed != '' AND date_completed IS NOT NULL) AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
        if ($last['section'] == 1) {
            $final_sql .= " AND section=1";
        }
        $final_sql .= " ORDER BY steps.section DESC, steps.sort_by DESC";

        $final = $db->getRow($final_sql);
        $final_rank = 0;
        $db->query("SET @rank=0");
        $rank_sql = "SELECT @rank:=@rank+1 as rank, id from dental_flowsheet_steps ORDER BY section ASC, sort_by ASC";
        $rank_query = $db->getResults($rank_sql);
        foreach ($rank_query as $rank_r) {
            if ($final['segmentid'] == $rank_r['id']) {
                $final_rank = $rank_r['rank'];
            }
        }
        */
    }
}
