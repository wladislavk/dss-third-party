<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Config\Repository as Config;
use Prettus\Repository\Eloquent\BaseRepository;

class AppointmentSummariesController extends BaseRestController
{
    /** @var AppointmentSummaryRepository */
    protected $repository;

    /** @var LetterRepository */
    private $letterRepository;

    public function __construct(Config $config, BaseRepository $repository, Request $request, LetterRepository $letterRepository)
    {
        parent::__construct($config, $repository, $request);
        $this->letterRepository = $letterRepository;
    }

    public function index()
    {
        return parent::index();
    }

    public function show($id)
    {
        return parent::show($id);
    }

    public function store()
    {
        return parent::store();
    }

    public function update($id)
    {
        return parent::update($id);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var AppointmentSummary $resource */
        $resource = $this->repository->find($id);
        $resource->delete();
        $criteria = [
            'info_id' => $id,
        ];
        $now = new \DateTime();
        $data = [
            'deleted' => 1,
            'deleted_by' => $this->user->getUserIdOrZero(),
            'deleted_on' => $now->format('Y-m-d H:i:s'),
        ];
        $this->letterRepository->updateBy($criteria, $data);
        return ApiResponse::responseOk('Resource deleted');
    }

    /**
     * @SWG\Get(
     *     path="/appt-summaries/by-patient/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByPatient($id)
    {
        $data = $this->repository->getByPatient($id);
        return ApiResponse::responseOk('', $data);
    }

    public function getStepsByRank($patientId)
    {
        /*
       $last_sql = "SELECT * FROM dental_flow_pg2_info info
    JOIN dental_flowsheet_steps steps on info.segmentid = steps.id
    WHERE (date_completed != '' AND date_completed IS NOT NULL) AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' ORDER BY date_completed DESC, info.id DESC";
        $last = $db->getRow($last_sql);
if($last['sectionid']==1){
    $final_sql = "SELECT * FROM dental_flow_pg2_info info
        JOIN dental_flowsheet_steps steps on info.segmentid = steps.id
        WHERE (date_completed != '' AND date_completed IS NOT NULL) AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' AND section=1
        order by steps.section DESC, steps.sort_by DESC";
}else{
    $final_sql = "SELECT * FROM dental_flow_pg2_info info
                    JOIN dental_flowsheet_steps steps on info.segmentid = steps.id
                    WHERE (date_completed != '' AND date_completed IS NOT NULL) AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' order by steps.section DESC, steps.sort_by DESC";
}

$final = $db->getRow($final_sql);
$final_rank = 0;
$db->query("SET @rank=0");
$rank_sql = "SELECT @rank:=@rank+1 as rank, id from dental_flowsheet_steps ORDER BY section ASC, sort_by ASC";
$rank_query = $db->getResults($rank_sql);
foreach ($rank_query as $rank_r) {
    if($final['segmentid']==$rank_r['id']){
        $final_rank = $rank_r['rank'];
    }
}

$db->query("SET @step_rank=0");

// first
$step_sql = "SELECT s.*, @step_rank:=@step_rank+1 as rank from dental_flowsheet_steps s WHERE s.section=1 ORDER BY s.sort_by ASC";
$step_q = $db->getResults($step_sql);

// second
$step_sql = "SELECT * from dental_flowsheet_steps WHERE section=2 ORDER BY sort_by ASC";
$step_q = $db->getResults($step_sql);

// first
$sched_sql = "SELECT * FROM dental_flow_pg2_info WHERE appointment_type=0 and patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' and segmentid!='' AND date_scheduled != '' AND date_scheduled != '0000-00-00'";
$sched_q = $db->getResults($sched_sql);

// second
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
