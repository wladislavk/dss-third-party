<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Helpers\AppointmentSummaryCreator;
use DentalSleepSolutions\Helpers\TrackerStepRetriever;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\JsonResponse;
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

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store()
    {
        $this->hasIp = false;
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

    /**
     * @SWG\Get(
     *     path="/appt-summaries/final-rank/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $id
     * @param TrackerStepRetriever $trackerStepRetriever
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFinalRank($id, TrackerStepRetriever $trackerStepRetriever)
    {
        $finalRank = $trackerStepRetriever->getFinalRank($id);
        return ApiResponse::responseOk('', $finalRank);
    }

    /**
     * @SWG\Get(
     *     path="/appt-summaries/future-appointment/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getFutureAppointment(int $id): JsonResponse
    {
        $data = $this->repository->getFutureAppointment($id);
        return ApiResponse::responseOk('', $data);
    }

    public function updateAppointment()
    {
        /*
        $id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : '');
        $comp_date = (!empty($_REQUEST['comp_date']) ? $_REQUEST['comp_date'] : '');
        $pid = (!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '');
        $s = "SELECT * FROM dental_flow_pg2_info WHERE id=".mysqli_real_escape_string($con,$id)." AND patientid=".mysqli_real_escape_string($con,$pid);

        $r = $db->getRow($s);

        if(!empty($r['segmentid']) && $r['segmentid'] == 7){ //Update dental device date for device delivery step
            $last_sql = "SELECT * FROM dental_flow_pg2_info WHERE patientid=".mysqli_real_escape_string($con,$pid)." ORDER BY date_completed DESC";

            $last_r = $db->getRow($last_sql);
            if(!empty($last_r['id']) && $id == $last_r['id']){
                $sql = "SELECT * FROM dental_ex_page5 where patientid='".$pid."'";

                if($db->getNumberRows($sql) == 0){
                    $s = "INSERT INTO dental_ex_page5 set
        			  dentaldevice_date='".date('Y-m-d', strtotime(mysqli_real_escape_string($con,$comp_date)))."',
        			  patientid='".$pid."',
        			  userid = '".s_for($_SESSION['userid'])."',
       	 			  docid = '".s_for($_SESSION['docid'])."',
        			  adddate = now(),
        			  ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
                } else {
                    $db->query("UPDATE dental_ex_page5 SET dentaldevice_date='".date('Y-m-d', strtotime(mysqli_real_escape_string($con,$comp_date)))."' where patientid='".$pid."'");
                }
            }
        }

        if (!empty($comp_date)) {
            $dateCompleted = date('Y-m-d', strtotime($comp_date));
        } else {
            $dateCompleted = date('Y-m-d');
        }

        $s = "update dental_flow_pg2_info set date_completed='" . $dateCompleted . "' WHERE id=".mysqli_real_escape_string($con,$id)." AND patientid=".mysqli_real_escape_string($con,$pid);
        $q = $db->query($s);

        if(!empty($q)) {
            echo '{"success":true}';
        } else {
            echo '{"error":true}';
        }
        */
    }

    /**
     * @param Request $request
     * @param AppointmentSummaryCreator $appointmentSummaryCreator
     * @return JsonResponse
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function addAppointment(Request $request, AppointmentSummaryCreator $appointmentSummaryCreator): JsonResponse
    {
        $stepId = (int)$request->input('step_id');
        $patientId = (int)$request->input('patient_id');
        $docId = $this->user->getDocIdOrZero();
        $userId = $this->user->getUserIdOrZero();

        try {
            $result = $appointmentSummaryCreator->createAppointmentSummary($stepId, $patientId, $docId, $userId);
        } catch (GeneralException $e) {
            // @todo: check if 400 should be returned
            return ApiResponse::responseError($e->getMessage(), 400);
        }
        return ApiResponse::responseOk('', $result);
    }
}
