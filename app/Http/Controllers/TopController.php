<?php namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

use Ds3\Libraries\Constants;
use Ds3\Contracts\UserInterface;
use Ds3\Contracts\LoginDetailInterface;
use Ds3\Contracts\LetterInterface;
use Ds3\Contracts\InsuranceInterface;
use Ds3\Contracts\LedgerInterface;
use Ds3\Contracts\InsurancePreauthInterface;
use Ds3\Contracts\HstInterface;
use Ds3\Contracts\PatientContactInterface;
use Ds3\Contracts\PatientInsuranceInterface;
use Ds3\Contracts\PatientInterface;
use Ds3\Contracts\NoteInterface;
use Ds3\Contracts\FaxInterface;
use Ds3\Contracts\SupportTicketInterface;
use Ds3\Contracts\FlowPg2Interface;
use Ds3\Contracts\QPage3Interface;
use Ds3\Contracts\TaskInterface;
use Ds3\Contracts\CompanyInterface;

class TopController extends Controller
{
	const SITE_NAME = 'Dental';

	private $routeParameters;

	private $user;
	private $loginDetail;
	private $letter;
	private $insurance;
	private $ledger;
	private $insurancePreauth;
	private $hst;
	private $patientContact;
	private $patientInsurance;
	private $patient;
	private $note;
	private $fax;
	private $supportTicket;
	private $flowPg2;
	private $qPage3;
	private $task;
	private $company;

	public function __construct(UserInterface $user,
								LoginDetailInterface $loginDetail,
								LetterInterface $letter,
								InsuranceInterface $insurance,
								LedgerInterface $ledger,
								InsurancePreauthInterface $insurancePreauth,
								HstInterface $hst,
								PatientContactInterface $patientContact,
								PatientInsuranceInterface $patientInsurance,
								PatientInterface $patient,
								NoteInterface $note,
								FaxInterface $fax,
								SupportTicketInterface $supportTicket,
								FlowPg2Interface $flowPg2,
								QPage3Interface $qPage3,
								TaskInterface $task,
								CompanyInterface $company)
	{
		$this->routeParameters = Route::current()->parameters();

		$this->user = $user;
		$this->loginDetail = $loginDetail;
		$this->letter = $letter;
		$this->insurance = $insurance;
		$this->ledger = $ledger;
		$this->insurancePreauth = $insurancePreauth;
		$this->hst = $hst;
		$this->patientContact = $patientContact;
		$this->patientInsurance = $patientInsurance;
		$this->patient = $patient;
		$this->note = $note;
		$this->fax = $fax;
		$this->supportTicket = $supportTicket;
		$this->flowPg2 = $flowPg2;
		$this->qPage3 = $qPage3;
		$this->task = $task;
		$this->company = $company;
	}

	public function index(Request $request)
	{
		$responseArray = array();

		$patientId = isset($this->routeParameters['pid']) ? $this->routeParameters['pid'] : null;

		if (empty(Session::get('userId'))) {
			return redirect('/manage/login');
		} else {
			$this->user->updateData(Session::get('userId'), array(
				'last_accessed_date' => date('Y-m-d H:i:s')
			));
		}

		$user = $this->user->findUser(Session::get('docId'));

		if ($user->homepage != '1') {
			// include_once 'includes/top2.htm';
		} else {
			if (!empty(Session::get('loginId'))) {
				$data = array(
					'loginid' 		=> Session::get('loginId'),
					'userid' 		=> Session::get('userId'),
					'cur_page' 		=> $request->path(),
					'ip_address' 	=> $request->ip()
				);

				$this->loginDetail->insertData($data);
			}

			if (str_contains($request->path(), 'q_page') == false && str_contains($request->path(), 'ex_page') == false &&
				str_contains($request->path(), 'q_sleep') == false && str_contains($request->path(), 'q_image') == false) {

				$unload = 0;
			} else {
				$unload = 1;
			}

			$where = array(
				'dental_letters.status' 	=> 0,
				'dental_letters.delivered' 	=> 0,
				'dental_letters.deleted' 	=> 0,
				'dental_letters.docid' 		=> Session::get('docId')
			);

			$generatedDates = $this->letter->getGeneratedDates($where);

			$generatedDate = $generatedDates[0];
			$numPendingLetters = count($generatedDates);
			$secondsPerDay = 86400;

			if (empty($generatedDate)) {
				$oldestLetter = 0;
			} else {
				$oldestLetter = floor((time() - $generatedDate->generated_date) / $secondsPerDay);
			}

			$numUnmailedLetters = count($this->letter->getUnmailedLetters(Session::get('docId')));

			$where = array('docid' => Session::get('docId'));
			$status = Constants::DSS_CLAIM_PENDING . ',' . Constants::DSS_CLAIM_SEC_PENDING;

			$numPendingClaims = count($this->insurance->get($where, $status));

			$where = array(
				'dental_ledger.status' 			=> Constants::DSS_TRXN_PENDING,
				'dental_ledger.docid' 			=> Session::get('docId'),
				'dental_transaction_code.docid' => Session::get('docId'),
				'dental_transaction_code.type' 	=> Constants::DSS_TRXN_TYPE_MED
			);

			$numPendingClaims = count($this->ledger->getPendingClaims($where));

			$where = array('docid' => Session::get('docId'));
			$status = Constants::DSS_CLAIM_PENDING . ',' . Constants::DSS_CLAIM_SEC_PENDING . ','
					. Constants::DSS_CLAIM_DISPUTE . ',' . Constants::DSS_CLAIM_SEC_DISPUTE;

			$numPendingClaims = count($this->insurance->get($where, $status));

			$status = Constants::DSS_CLAIM_PENDING . ',' . Constants::DSS_CLAIM_SEC_PENDING . ','
					. Constants::DSS_CLAIM_DISPUTE . ',' . Constants::DSS_CLAIM_SEC_DISPUTE;

			$numPendingNodssClaims = count($this->insurance->getPendingNodssClaims(Session::get('docId'), $status));

			$numUnmailedClaims = count($this->insurance->getUnmailedClaims(Session::get('docId'), Constants::DSS_CLAIM_PENDING, Constants::DSS_CLAIM_SEC_PENDING));

			$where = array('docid' => Session::get('docId'));
			$status = Constants::DSS_CLAIM_REJECTED . ',' . Constants::DSS_CLAIM_SEC_REJECTED;

			$numRejectedClaims = count($this->insurance->get($where, $status));

			$numPreauth = count($this->insurancePreauth->getPreauth(Session::get('docId'), Constants::DSS_PREAUTH_COMPLETE));

			$where = array('doc_id' => Session::get('docId'));
			$status = Constants::DSS_PREAUTH_PENDING;

			$numPendingPreauth = count($this->insurancePreauth->get($where, $status));

			$numHst = count($this->hst->get(1, Constants::DSS_HST_COMPLETE, array(
				'doc_id' => Session::get('docId')
			)));

			$numRequestedHst = count($this->hst->get(1, Constants::DSS_HST_REQUESTED, array(
				'doc_id' => Session::get('docId')
			)));

			$numRejectedHst = count($this->hst->get(1, Constants::DSS_HST_REJECTED, array(
				'doc_id' => Session::get('docId')
			)));

			$numPatientContacts = count($this->patientContact->get(array(
				'dental_patients.docid' => Session::get('docId')
			)));

			$numPatientInsurance = count($this->patientInsurance->get(array(
				'dental_patients.docid' => Session::get('docId')
			)));

			$join = array('patientid', 'parent_patientid');

			// change name!
			$numC = count($this->patient->getJoinPatients(array(
				'p.docid' => Session::get('docId')
			), $join));

			$numPendingDuplicates = count($this->patient->getPendingDuplicates(array(
				'docid' => Session::get('docId')
			), '3,4'));

			$numBounce = count($this->patient->get(array(
				'dental_patients.email_bounce' => 1,
				'dental_patients.docid' => Session::get('docId')
			)));

			$numUnsigned = count($this->note->getUnsigned(Session::get('docId')));

			$numRejectedPreauth = count($this->insurancePreauth->getPreauth(Session::get('docId'), Constants::DSS_PREAUTH_REJECTED));

			$numFaxAlerts = count($this->fax->getFaxAlerts(Session::get('docId')));

			$numSupport = count($this->supportTicket->getSupport(Session::get('docId'), Constants::DSS_TICKET_STATUS_CLOSED));

			$onClick = '';

			if ($request->path() == '/manage/flowsheet3' || $request->path() == '/manage/flowsheet4') {
				$stepResponse = $this->flowPg2->getStep($patientId);

				if (!empty($stepResponse)) {
					$stepResponse = array($stepResponse->steparray);
					$step = explode(',', $stepResponse['0']);
					$stepJson = json_encode($step);
					$onClick .= 'hideallblocksForFlowsheet(' . $step_json. ');';
				} else {
					$onClick .= 'hideallblocks();';
				}
			}

			if (isset($this->routeParameters['preview']) && $this->routeParameters['preview'] == '1') {
				$onClick .= ' check();';
			}

			if (isset($this->routeParameters['page']) && $this->routeParameters['page'] == 'page2') {
				$cssForPage2 = true;
				$onClick .= " $('#flowsheet_page1').css('display', 'none'); $('#flowsheet_page2').css('display', 'block');";
			} else {
				$cssForPage2 = false;
			}

			$theName 			= null;
			$medicare 			= null;
			$premed 			= null;
			$allergen 			= null;
			$title 				= null;

			if (!empty($patientId)) {
				$title = '';

				$where = array(
					'docid' => Session::get('docId'),
					'patientid' => $patientId
				);

				$patients = $this->patient->get($where);

				$patient = count($patients) ? $patients[0] : null;

			    if (!empty($patient)) {
			        $premed = $patient->premedcheck;
			        $medicare = ($patient->p_m_ins_type == 1);

			        if ($premed) {
			          $title .= "Pre-medication: " . $patient->premed . "\n";
			        }

			        $qPage3 = $this->qPage3->get($patientId);

			        $allergen = !empty($qPage3) ? $qPage3->allergenscheck : null;

			        if ($allergen) {
			          $title .= "Allergens: " . $qPage3->other_allergens;
			        }
			        
			        $theName = $patient->firstname . ' ' . $patient->lastname;
			    }
		    }

	        $numTasks = count($this->task->get(Session::get('userId'), null, null, 'task'));

	        $messageCount = $numPendingLetters + $numPreauth + $numRejectedPreauth +
	        				$numPatientContacts + $numPatientInsurance + $numC +
	        				$numBounce + $numUnsigned + $numPendingDuplicates;

	       	if (Session::get('userType') == Constants::DSS_USER_TYPE_SOFTWARE) {
	       		$messageCount += $numUnmailedClaims + $numPendingNodssClaims;
	       	} else {
	       		$messageCount += $numPendingClaims;
	       	}

	       	if (date('N') == 7) {
				$thisSunday = date('Y-m-d');
				$nextMonday = date('Y-m-d',  strtotime("next Tuesday"));
				$nextSunday = date('Y-m-d',  strtotime("next Sunday"));
			} else {
				$thisSunday = date('Y-m-d',  strtotime("next Sunday"));
				$nextMonday = date('Y-m-d',  strtotime("next Monday"));
				$nextSunday = date('Y-m-d',  strtotime("next Sunday + 1 week"));
			}

			// check variable name!

			$overdueTasks = $this->task->get(Session::get('userId'), null, null, 'task', 'od');

			$todayTasks = $this->task->get(Session::get('userId'), null, null, 'task', 'tod');

			$tomorrowTasks = $this->task->get(Session::get('userId'), null, null, 'task', 'tom');

			$thisWeekTasks = $this->task->get(Session::get('userId'), null, null, 'task', 'tw', array(
				'thisSun' => $thisSunday
			));

			$nextWeekTasks = $this->task->get(Session::get('userId'), null, null, 'task', 'nw', array(
				'nextMon' => $nextMonday,
				'nextSun' => $nextSunday
			));

			$laterTasks = $this->task->get(Session::get('userId'), null, null, 'task', 'lat', array(
				'nextSun' => $nextSunday
			));

			$showLinkOnlineCe = false;

			if (Session::get('docId') == Session::get('userId')) {
				$course = $this->user->findUser(Session::get('userId'))->use_course;

				if ($course == 1) {
					$showLinkOnlineCe = true;
				}
			} else {
				$course = $this->user->getCourseJoin(Session::get('userId'));

				if ($course['use_course'] == 1 && $course['use_course_staff'] == 1) {
					$showLinkOnlineCe = true;
				}
			}

			$logo = $this->company->getLogo(Session::get('userId'))->logo;

			$numPatientTasks 			= null;
			$futureTasks 				= null;
			$showWarningProfile 		= null;
			$showWarningQuestionnaire 	= null;
			$showWarningBounced 		= null;
			$rejectedInsurance 			= null;
			$hideWarnings				= null;

			if (!empty($patientId)) {

				$numPatientTasks = count($this->task->get(Session::get('userId'), Session::get('docId'), $patientId, null));

				if ($numPatientTasks > 0) {
					$overdueTasks = $this->task->get(Session::get('userId'), Session::get('docId'), $patientId, null, 'od');

					$todayTasks = $this->task->get(Session::get('userId'), Session::get('docId'), $patientId, null, 'tod');

					$tomorrowTasks = $this->task->get(Session::get('userId'), Session::get('docId'), $patientId, null, 'tom');

					$futureTasks = $this->task->get(Session::get('userId'), Session::get('docId'), $patientId, null, 'fut');
				}

				$patientParent = $this->patient->get(array('parent_patientid' => $patientId));

				$numChanges = $this->numPatientChanges($patientId);

				$totalContacts = count($this->patientContact->get(array(
					'dental_patients.docid' 	=> Session::get('docId'),
					'dental_patients.patientid' => $patientId
				)));

				$totalInsurance = count($this->patientInsurance->get(array(
					'dental_patients.docid' 	=> Session::get('docId'),
					'dental_patients.patientid' => $patientId
				)));

				if ((count($patientParent) + $totalContacts + $totalInsurance) > 0) {
					$showWarningProfile = true;
				}

				$existPatient = $this->patient->get(array(
					'patientid' => $patientId
				));
				$existPatient = count($existPatient) ? $existPatient[0] : null;

				if (!empty($existPatient) && ($existPatient->symptoms_status == 2 &&
					$existPatient->treatments_status == 2 && $existPatient->history_status == 2 &&
					$existPatient->sleep_status == 2)) {

					$showWarningQuestionnaire = true;
				}

				$email = $this->patient->get(array(
					'email_bounce' => 1,
					'patientid' => $patientId
				));

				if (count($email)) {
					$showWarningBounced = true;
				}

				$status = Constants::DSS_CLAIM_REJECTED . ',' . Constants::DSS_CLAIM_SEC_REJECTED;

				$rejectedInsurance = $this->insurance->get(array('patientid' => $patientId), $status);

				// Undefined constants
				/*
				$status = Constants::DSS_HST_REQUSTED . ',' . Constants::DSS_HST_PENDING . ','
						. Constants::DSS_HST_SCHEDULED . ',' . Constants::DSS_HST_REJECTED;

				$hstUncompleted = $this->hst->get(0, $status, array(
					'patient_id' => $patientId
				));
				*/

				if (Session::get('hidePatWarnings') == $patientId) {
					$hideWarnings = true;
				} else {
					$hideWarnings = false;
					Session::put('hidePatWarnings', null);
				}
			}	

			$useLetters = ($this->user->findUser(Session::get('docId'))->use_letters == '1');

			$responseArray = array(
				'siteName' 					=> self::SITE_NAME,
				'cssForPage2'				=> $cssForPage2,
				'messageCount' 				=> $messageCount,
				'numSupport' 				=> $numSupport,
				'numTasks' 					=> $numTasks,
				'showLinkOnlineCe' 			=> $showLinkOnlineCe,
				'logo'						=> $logo,
				'theName'					=> $theName,
				'medicare'					=> $medicare,
				'premed'					=> $premed,
				'allergen'					=> $allergen,
				'title'						=> $title,
				'numPatientTasks'			=> $numPatientTasks,
				'overdueTasks'				=> $overdueTasks,
				'todayTasks'				=> $todayTasks,
				'tomorrowTasks'				=> $tomorrowTasks,
				'futureTasks'				=> $futureTasks,
				'thisWeekTasks'				=> $thisWeekTasks,
				'nextWeekTasks'				=> $nextWeekTasks,
				'laterTasks'				=> $laterTasks,
				'showWarningProfile' 		=> $showWarningProfile,
				'showWarningQuestionnaire' 	=> $showWarningQuestionnaire,
				'showWarningBounced'		=> $showWarningBounced,
				'rejectedInsurance'			=> $rejectedInsurance,
				'numPendingClaims'			=> $numPendingClaims,
				'numPatientContacts'		=> $numPatientContacts,
				'numPatientInsurance'		=> $numPatientInsurance,
				'numC'						=> $numC,
				'useLetters'				=> $useLetters,
				'numUnmailedLetters'		=> $numUnmailedLetters,
				'numPendingLetters'			=> $numPendingLetters,
				'numPreauth'				=> $numPreauth,
				'numHst'					=> $numHst,
				'numRejectedHst'			=> $numRejectedHst,
				'numRequestedHst'			=> $numRequestedHst,
				'numPendingNodssClaims'		=> $numPendingNodssClaims,
				'numUnmailedClaims'			=> $numUnmailedClaims,
				'numRejectedClaims'			=> $numRejectedClaims,
				'numUnsigned'				=> $numUnsigned,
				'numRejectedPreauth'		=> $numRejectedPreauth,
				'numFaxAlerts'				=> $numFaxAlerts,
				'numPendingDuplicates'		=> $numPendingDuplicates,
				'numBounce'					=> $numBounce,
				'onClick'					=> $onClick,
				'hideWarnings'				=> $hideWarnings,
				'patientId'					=> $patientId,
				'username'					=> Session::get('username')
			);

			return $responseArray;
		}
	}

	public function hideWarnings(Request $request)
	{
		if ($request->ajax()) {
			Session::put($request->get('attribute'), $request->get('value'));

			return 'Success';
		}
	}

	private function numPatientChanges($patientId)
	{
		$numChanges = 0;

		$patient = $this->patient->get(array(
			'patientid' => $patientId
		));

		$patient = isset($patient[0]) ? $patient[0] : array();

		$patientParent = $this->patient->get(array(
			'parent_patientid' => $patientId
		));

		$patientParent = isset($patientParent[0]) ? $patientParent[0] : array();

		$fields = array(
			'firstname', 'middlename', 'lastname', 'preferred_name', 'email', 'home_phone', 'work_phone',
			'cell_phone', 'add1', 'add2', 'city', 'state', 'zip', 'feet', 'inches', 'weight', 'bmi', 'dob',
			'gender', 'marital_status', 'ssn', 'preferredcontact', 'emergency_name', 'emergency_relationship',
			'emergency_number', 'p_m_relation', 'p_m_partyfname', 'p_m_partymname', 'p_m_partylname', 'ins_dob',
			'p_m_ins_id', 'p_m_ins_grp', 'p_m_ins_plan', 'p_m_ins_type', 's_m_relation', 's_m_partyfname',
			's_m_partymname', 's_m_partylname', 'ins2_dob', 's_m_ins_id', 's_m_ins_grp', 's_m_ins_plan',
			's_m_ins_type', 'employer', 'emp_add1', 'emp_add2', 'emp_city', 'emp_state', 'emp_zip', 'emp_phone',
			'emp_fax', 'docsleep', 'docpcp', 'docdentist', 'docent', 'docmdother' 
		);

		if (!empty($patientParent)) {
			foreach ($fields as $field) {
				if(trim($patient->$field) != trim($patientParent->$field)){
					$numChanges++;
				}
			}
		}

		return $numChanges;
	}
}