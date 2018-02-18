<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Helpers\TrackerStepRetriever;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFutureAppointment($id)
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

    public function updateAppointmentToday()
    {
        /*
        $id = intval(!empty($_REQUEST['id']) ? $_REQUEST['id'] : '');
        $pid = intval(!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '');
        $docId = intval($_SESSION['docid']);
        $numsteps = null;
        $impression = true;
        $letterid = array();
        $create = true;


        $let_sql = "SELECT use_letters, tracker_letters FROM dental_users WHERE userid='$docId'";

        $let_r = $db->getRow($let_sql);
        $create_letters = ($let_r['use_letters'] && $let_r['tracker_letters']);
        if($id == "7" || $id == "4"){  //device deliver - check if impressions are done

            $imp_s = "SELECT * from dental_flow_pg2_info WHERE (segmentid='7' OR segmentid='4') AND patientid='$pid' AND appointment_type=1 ORDER BY date_completed DESC, id DESC";
            $imp_q = $db->getResults($imp_s);
            $imp_n = count($imp_q);
            if($imp_n == 0){
                $impression=false;
            }else{
                $imp_r = (!empty($imp_q[0]) ? $imp_q[0] : array());
                $impression = $imp_r['device_id'];
            }
        }

        if($id == "7"){
            $sql = "SELECT * FROM dental_ex_page5 where patientid='$pid'";
            if($db->getNumberRows($sql)==0){
                $sqlex = "INSERT INTO dental_ex_page5 set
                  dentaldevice_date=CURDATE(),
                  patientid='$pid',
                  userid = '".s_for($_SESSION['userid'])."',
                  docid = '".s_for($_SESSION['docid'])."',
                  adddate = now(),
                  ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
            }else{

                $sqlex = "update dental_ex_page5 set dentaldevice_date=CURDATE() where patientid='$pid'";
            }
            $qex = $db->query($sqlex);

        }

        if(!empty($create)){
            $s = "INSERT INTO dental_flow_pg2_info SET
        patientid= '$pid',
        segmentid = '$id',
		    appointment_type = 1,";

            if(!empty($impression)){
                $s .= " device_id='".$impression."',";
            }

            $s .=" date_completed = CURDATE()";
            $insert_id = $db->getInsertId($s);

            if($insert_id){
                $db->query("DELETE FROM dental_flow_pg2_info WHERE appointment_type=0 AND patientid='$pid'");
            }

            if(!empty($create_letters)){
                if ($id == "8") { // Follow-Up/Check
                    $trigger_query = "SELECT dental_flow_pg2_info.patientid, dental_flow_pg2_info.date_completed FROM dental_flow_pg2_info WHERE dental_flow_pg2_info.segmentid = '7' AND dental_flow_pg2_info.date_completed != '0000-00-00' AND dental_flow_pg2_info.patientid = '$pid'";

                    $numrows = ($db->getNumberRows($trigger_query));
                    $letterid = array();
                    if ($numrows > 0) {
                        $letterid[] = trigger_letter16($pid, $insert_id);
                    }
                }

                if ($id == "13") { // Termination
                    $letterid[] = trigger_letter24($pid, $insert_id);
                }

                if ($id == "4") { // Impressions
                    $letterid[] = trigger_letter9($pid, $insert_id); //send TY MD referral when impressions completed
                    //$letterid[] = trigger_letter13($pid, $numsteps);
                }
            }

            $consult_query = "SELECT date_completed FROM dental_flow_pg2_info WHERE segmentid = '2' and patientid = '$pid' LIMIT 1";

            $consult_result = $db->getResults($consult_query);
            $consulted = false;
            if(count($consult_result)>0){
                $consult_date = $consult_result[0]['date_completed'];
                if ($consult_date != "0000-00-00") {
                    $consulted = true;
                }
            }

            if(!empty($create_letters)){
                // Delaying Treatment / Waiting
                if ($consulted == true && $id == "5") {
                    $letterid[] = trigger_letter10($pid, $insert_id);
                }

                // Refused Treatment
                if ($consulted == true && $id == "6") {
                    $letterid[] = trigger_letter8($pid, $insert_id);
                    $letterid[] = trigger_letter11($pid, $insert_id);
                }

                // Patient Non Compliant
                if ($id == "9") {
                    $letterid[] = trigger_letter17($pid, $insert_id);
                }

                // Treatment Complete
                if ($id == "11") {
                    $letterid[] = trigger_letter19($pid, $insert_id);
                }

                if ($id == "12") {
                    $letterid[] = trigger_letter21($pid, $insert_id);
                }

                if ($id == "14") {
                    $letterid[] = trigger_letter7($pid, $insert_id);
                }
            }

            if (!empty($letterid)) {
                // Cast values to integers
                array_walk($letterid, function(&$each){
                    $each = intval($each);
                });

                // Remove duplicates
                $letterid = array_unique($letterid);

                // Keep values greater than zero
                $letterid = array_filter($letterid, function($each){
                    return $each > 0;
                });
            }

            $letter_count = 0;
            if(count($letterid)>0 && $create_letters){
                $letteridlist = implode(",", $letterid);

                $dental_letters_query = "SELECT patientid, letterid, UNIX_TIMESTAMP(generated_date) as generated_date, topatient, md_list, md_referral_list, pdf_path, status, delivered, dental_letter_templates.name, dental_letter_templates.template, deleted FROM dental_letters LEFT JOIN dental_letter_templates ON dental_letters.templateid=dental_letter_templates.id WHERE patientid = '".$pid."' AND (letterid IN(".$letteridlist.") OR parentid IN(".$letteridlist.")) ;";
                $dental_letters_res = $db->getResults($dental_letters_query);
                $dental_letters = array();
                if (!empty($dental_letters_res)) foreach ($dental_letters_res as $row) {
                    $dental_letters[] = $row;
                    $contacts = get_contact_info((($row['topatient'] == "1") ? $row['patientid'] : ''), $row['md_list'], $row['md_referral_list']);
                    $letter_count += count($contacts['patient'])+count($contacts['md_referrals'])+count($contacts['mds']);
                }
            }

            $segments = array();
            $segments[1] = "Initial Contact";
            $segments[15] = "Baseline Sleep Test";
            $segments[2] = "Consult";
            $segments[4] = "Impressions";
            $segments[7] = "Device Delivery";
            $segments[8] = "Check / Follow Up";
            $segments[10] = "Home Sleep Test";
            $segments[3] = "Sleep Study";
            $segments[11] = "Treatment Complete";
            $segments[12] = "Annual Recall";
            $segments[14] = "Not a Candidate";
            $segments[5] = "Delaying Tx / Waiting";
            $segments[9] = "Pt. Non-Compliant";
            $segments[6] = "Refused Treatment";
            $segments[13] = "Termination";

            $title = $segments[$id];

            $next_sql = "SELECT steps.* FROM dental_flowsheet_steps steps
          JOIN dental_flowsheet_steps_next next ON steps.id = next.child_id
          WHERE next.parent_id='$id'
          ORDER BY next.sort_by ASC";

            $next_q = $db->getResults($next_sql);
        }

        $impression_json = (!empty($impression)) ? $impression : 'false';
        if(!empty($s)){
            echo '{"success":true, "datecomp":"'.date('m/d/Y').'", "id":"'.$insert_id.'", "next_steps":"'.$next.'", "title":"'.$title.'", "letters":"'.$letter_count.'", "impression":'.$impression_json.'}';
        }else{
            echo '{"error":true}';
        }
        */
    }
}
