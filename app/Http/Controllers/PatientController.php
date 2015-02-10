<?php namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;

use Ds3\Libraries\Constants;
use Ds3\Libraries\Password;
use Ds3\Libraries\MDReferralFilter;

use Ds3\Contracts\CompanyInterface;
use Ds3\Contracts\UserInterface;
use Ds3\Contracts\LetterInterface;
use Ds3\Contracts\ContactInterface;
use Ds3\Contracts\PatientInterface;
use Ds3\Contracts\SummaryInterface;
use Ds3\Contracts\InsurancePreauthInterface;
use Ds3\Contracts\SummSleeplabInterface;
use Ds3\Contracts\FlowPg2Interface;
use Ds3\Contracts\FaxInterface;
use Ds3\Contracts\FlowPg1Interface;
use Ds3\Contracts\FlowPg2InfoInterface;
use Ds3\Contracts\PatientSummaryInterface;
use Ds3\Contracts\NotificationInterface;
use Ds3\Contracts\QImageInterface;
use Ds3\Contracts\LocationInterface;
use Ds3\Contracts\LetterTemplateInterface;

class PatientController extends Controller
{
	private $company;
	private $user;
	private $letter;
	private $contact;
	private $patient;
	private $summary;
	private $insurancePreauth;
	private $summSleeplab;
	private $flowPg2;
	private $fax;
	private $flowPg1;
	private $flowPg2Info;
	private $patientSummary;
	private $notification;
	private $qImage;
	private $location;
	private $letterTemplate;
	
	private $request;

	public function __construct(CompanyInterface $company,
								UserInterface $user,
								LetterInterface $letter,
								ContactInterface $contact,
								PatientInterface $patient,
								SummaryInterface $summary,
								InsurancePreauthInterface $insurancePreauth,
								SummSleeplabInterface $summSleeplab,
								FlowPg2Interface $flowPg2,
								FaxInterface $fax,
								FlowPg1Interface $flowPg1,
								FlowPg2InfoInterface $flowPg2Info,
								PatientSummaryInterface $patientSummary,
								NotificationInterface $notification,
								QImageInterface $qImage,
								LocationInterface $location,
								LetterTemplateInterface $letterTemplate)
	{
		$this->company 			= $company;
		$this->user 			= $user;
		$this->letter 			= $letter;
		$this->contact 			= $contact;
		$this->patient 			= $patient;
		$this->summary 			= $summary;
		$this->insurancePreauth = $insurancePreauth;
		$this->summSleeplab 	= $summSleeplab;
		$this->flowPg2 			= $flowPg2;
		$this->fax 				= $fax;
		$this->flowPg1 			= $flowPg1;
		$this->flowPg2Info 		= $flowPg2Info;
		$this->patientSummary 	= $patientSummary;
		$this->notification 	= $notification;
		$this->qImage 			= $qImage;
		$this->location 		= $location;
		$this->letterTemplate 	= $letterTemplate;

		$this->request = Request::all();
	}

	public function index()
	{
		// if(!isset($_GET['noheaders'])){

		$patientId = $this->request['patientId'];

		$billing = $this->company->getBilling(array(
			'u.userid' => Session::get('docId')
		));

		if (count($billing)) {
			$exclusiveBilling = $billing[0]->exclusive;
			$nameBilling = $billing[0]->name;
		} else {
			$exclusiveBilling = 0;
			$nameBilling = 'DSS';
		}

		$docPatientPortal = $this->user->findUser(Session::get('docId'))->use_patient_portal;

		if (!empty($this->request['patientSub']) && $this->request['patientSub'] == 1) {
			if(!empty($this->request['PMEligiblePayer'])){
				$PMEligiblePayerId = substr($_POST['PMEligiblePayer'], 0, strpos($_POST['PMEligiblePayer'], '-'));
				$PMEligiblePayerName = substr($_POST['PMEligiblePayer'], (strpos($_POST['PMEligiblePayer'], '-') + 1));
			}else{
				$PMEligiblePayerId = '';
				$PMEligiblePayerName = '';
			}

			if(!empty($this->request['SMEligiblePayer'])){
				$SMEligiblePayerId = substr($_POST['SMEligiblePayer'],0,strpos($_POST['SMEligiblePayer'], '-'));
				$SMEligiblePayerName = substr($_POST['SMEligiblePayer'],(strpos($_POST['SMEligiblePayer'], '-')+1));
			}else{
				$SMEligiblePayerId = '';
				$SMEligiblePayerName = '';
			}

			$usePatientPortal = $this->request['usePatientPortal'];

			if (!empty($this->request['ed'])) {
				$patient = $this->patient->get(array(
					'patientid' => $patientId
				))[0];

				$oldReferredBy = $patient->referred_by;
				$oldReferredSource = $patient->referred_source;
				$oldPMInsCo = $patient->p_m_ins_co;

				if ($patient->registration_status == 2 && $this->request['email'] != $patient->email) {
					sendUpdatedEmail($patientId, $this->request['email'], $patient->email, 'doc');
				} elseif (isset($this->request['sendRem'])) {
					sendReminderEmail($this->request['ed'], $this->request['email']);
				} elseif (!isset($this->request['sendReg']) && $patient->registration_status == 1 && trim($this->request['email']) != trim($patient->email)) {
					if ($docPatientPortal && $usePatientPortal) {
						sendRegistrationEmail($this->request['ed'], $this->request['email'], '');
					}
				}

				$data = array(
					'firstname' 				=> $this->request['firstname'],
					'lastname' 					=> $this->request['lastname'],
					'middlename' 				=> $this->request['middlename'],
					'preferred_name' 			=> $this->request['preferred_name'],
					'salutation' 				=> $this->request['salutation'],
					'member_no' 				=> $this->request['member_no'],
					'group_no' 					=> $this->request['group_no'],
					'plan_no' 					=> $this->request['plan_no'], 
					'add1' 						=> $this->request['add1'], 
					'add2' 						=> $this->request['add2'], 
					'city' 						=> $this->request['city'], 
					'state' 					=> $this->request['state'], 
					'zip' 						=> $this->request['zip'], 
					'dob' 						=> $this->request['dob'], 
					'gender' 					=> $this->request['gender'], 
					'marital_status' 			=> $this->request['marital_status'],
					'ssn' 						=> $this->num($this->request['ssn'], false), 
					'feet'						=> $this->request['feet'],
					'inches'					=> $this->request['inches'],
					'weight'					=> $this->request['weight'],
					'bmi'						=> $this->request['bmi'],
					'home_phone' 				=> $this->num($this->request['home_phone']), 
					'work_phone' 				=> $this->num($this->request['work_phone']), 
					'cell_phone' 				=> $this->num($this->request['cell_phone']),
					'best_time' 				=> $this->request['best_time'],
					'best_number' 				=> $this->request['best_number'],
					'email' 					=> $this->request['email'],
					'patient_notes' 			=> $this->request['patient_notes'], 
					'p_d_party' 				=> $this->request['p_d_party'], 
					'p_d_relation' 				=> $this->request['p_d_relation'], 
					'p_d_other' 				=> $this->request['p_d_other'], 
					'p_d_employer' 				=> $this->request['p_d_employer'], 
					'p_d_ins_co' 				=> $this->request['p_d_ins_co'], 
					'p_d_ins_id' 				=> $this->request['p_d_ins_id'], 
					's_d_party' 				=> $this->request['s_d_party'], 
					's_d_relation' 				=> $this->request['s_d_relation'], 
					's_d_other' 				=> $this->request['s_d_other'], 
					's_d_employer' 				=> $this->request['s_d_employer'], 
					's_d_ins_co' 				=> $this->request['s_d_ins_co'], 
					's_d_ins_id' 				=> $this->request['s_d_ins_id'], 
					'p_m_partyfname' 			=> $this->request['p_m_partyfname'],
					'p_m_partymname' 			=> $this->request['p_m_partymname'],
					'p_m_partylname' 			=> $this->request['p_m_partylname'],
					'p_m_gender' 				=> $this->request['p_m_gender'],
					'p_m_ins_grp' 				=> $this->request['p_m_ins_grp'],
					's_m_ins_grp' 				=> $this->request['s_m_ins_grp'],
					'p_m_dss_file' 				=> $this->request['p_m_dss_file'],
					's_m_dss_file' 				=> $this->request['s_m_dss_file'],
					'p_m_same_address' 			=> $this->request['p_m_same_address'],
					's_m_same_address' 			=> $this->request['s_m_same_address'],
					'p_m_address' 				=> $this->request['p_m_address'],
					'p_m_city' 					=> $this->request['p_m_city'],
					'p_m_state' 				=> $this->request['p_m_state'],
					'p_m_zip' 					=> $this->request['p_m_zip'],
					's_m_address' 				=> $this->request['s_m_address'],
					's_m_city' 					=> $this->request['s_m_city'],
					's_m_state' 				=> $this->request['s_m_state'],
					's_m_zip' 					=> $this->request['s_m_zip'],
					'p_m_ins_type' 				=> $this->request['p_m_ins_type'],
					's_m_ins_type' 				=> $this->request['s_m_ins_type'],
					'p_m_ins_ass' 				=> $this->request['p_m_ins_ass'],
					's_m_ins_ass' 				=> $this->request['s_m_ins_ass'],
					'ins_dob' 					=> $this->request['ins_dob'],
					'ins2_dob' 					=> $this->request['ins2_dob'],
					'p_m_relation' 				=> $this->request['p_m_relation'], 
					'p_m_other' 				=> $this->request['p_m_other'], 
					'p_m_employer' 				=> $this->request['p_m_employer'], 
					'p_m_ins_co' 				=> $this->request['p_m_ins_co'], 
					'p_m_ins_id' 				=> $this->request['p_m_ins_id'], 
					'p_m_eligible_payer_id' 	=> $PMEligiblePayerId,
					'p_m_eligible_payer_name' 	=> $PMEligiblePayerName,
					'has_s_m_ins' 				=> $this->request['s_m_ins'],
					's_m_partyfname' 			=> $this->request['s_m_partyfname'],
					's_m_partymname' 			=> $this->request['s_m_partymname'],
					's_m_partylname' 			=> $this->request['s_m_partylname'], 
					's_m_gender' 				=> $this->request['s_m_gender'],
					's_m_relation' 				=> $this->request['s_m_relation'], 
					's_m_other' 				=> $this->request['s_m_other'], 
					's_m_employer' 				=> $this->request['s_m_employer'], 
					's_m_ins_co' 				=> $this->request['s_m_ins_co'], 
					's_m_ins_id' 				=> $this->request['s_m_ins_id'],
					'p_m_ins_plan' 				=> $this->request['p_m_ins_plan'],
					's_m_ins_plan' 				=> $this->request['s_m_ins_plan'], 
					'employer' 					=> $this->request['employer'], 
					'emp_add1' 					=> $this->request['emp_add1'], 
					'emp_add2' 					=> $this->request['emp_add2'], 
					'emp_city' 					=> $this->request['emp_city'], 
					'emp_state' 				=> $this->request['emp_state'], 
					'emp_zip' 					=> $this->request['emp_zip'], 
					'emp_phone' 				=> $this->num($this->request['emp_phone']), 
					'emp_fax' 					=> $this->num($this->request['emp_fax']), 
					'plan_name' 				=> $this->request['plan_name'], 
					'group_number' 				=> $this->request['group_number'], 
					'ins_type' 					=> $this->request['ins_type'], 
					'accept_assignment' 		=> $this->request['accept_assignment'], 
					'print_signature' 			=> $this->request['print_signature'], 
					'medical_insurance' 		=> $this->request['medical_insurance'], 
					'mark_yes' 					=> $this->request['mark_yes'],
					'inactive' 					=> $this->request['inactive'],
					'partner_name' 				=> $this->request['partner_name'],
					'docsleep' 					=> $this->request['docsleep'],
					'docpcp' 					=> $this->request['docpcp'],
					'mark_yes' 					=> $this->request['mark_yes'],
					'docdentist'				=> $this->request['docdentist'],
					'docent' 					=> $this->request['docent'],
					'docmdother' 				=> $this->request['docmdother'],
					'docmdother2' 				=> $this->request['docmdother2'],
					'docmdother3' 				=> $this->request['docmdother3'],
					'emergency_name' 			=> $this->request['emergency_name'],
					'emergency_relationship' 	=> $this->request['emergency_relationship'],
					'emergency_number' 			=> $this->num($this->request['emergency_number']),
					'docent'	 				=> $this->request['docent'],
					'emergency_name' 			=> $this->request['emergency_name'],
					'emergency_number' 			=> $this->num($this->request['emergency_number']),
					'referred_source' 			=> $this->request['referred_source'],
					'referred_by' 				=> $this->request['referred_by'],
					'referred_notes' 			=> $this->request['referred_notes'],
					'copyreqdate' 				=> $this->request['copyreqdate'],
					'status' 					=> $this->request['status'],
					'use_patient_portal' 		=> $this->request['use_patient_portal'],
					'preferredcontact' 			=> $this->request['preferredcontact']
				);

				if ($this->request['email'] != $patient->email) {
					$data['email_bounce'] = 0;
				}

				$this->patient->updateData(array(
					'patientid' => $this->request['ed']
				), $data);

				$data = array(
					'email' => $this->request['email']
				);

				$this->patient->updateData(array(
					'parent_patientid' => $this->request['ed']
				), $data);

				if ($oldPMInsCo != $this->request['p_m_ins_co'] || $patient->p_m_relation != $this->request['p_m_relation'] ||
					$patient->p_m_partyfname != $this->request['p_m_partyfname'] || $patient->p_m_partylname != $this->request['p_m_partylname'] ||
					$patient->ins_dob != $this->request['ins_dob'] || $patient->p_m_ins_type != $this->request['p_m_ins_type'] ||
					$patient->p_m_ins_ass != $this->request['p_m_ins_ass'] || $patient->p_m_ins_id != $this->request['p_m_ins_id'] ||
					$patient->p_m_ins_grp != $this->request['p_m_ins_grp'] || $patient->p_m_ins_plan != $this->request['p_m_ins_plan']) {

					$data = array(
						'status' 		=> Constants::DSS_PREAUTH_REJECTED,
						'reject_reason' => Session::get('name') . ' altered patient insurance information requiring VOB resubmission on ' . date('m/d/Y h:i'),
						'viewed' 		=> 1
					);

					$countOfAffectedRows = $this->insurancePreauth->updateData($this->request['ed'], Constants::DSS_PREAUTH_PENDING, Constants::DSS_PREAUTH_PREAUTH_PENDING, $data);

					if ($countOfAffectedRows >= 1) {
						$vob = $this->createVob($this->request['ed']);
					}
				}

				if (!empty($this->request['location'])) {
					$summary = $this->summary->get($patientId);

					if (!empty($summary)) {
						$data = array(
							'location' => $this->request['location']
						);

						$this->summary->updateData(array(
							'patientid' => $patientId
						), $data);
					} else {
						$data = array(
							'location' 	=> $this->request['location'],
							'patientid' => $patientId
						);

						$this->summary->insertData($data);
					}
				}

				$patient = $this->patient->get(array(
					'patientid' => $this->request['ed']
				))[0];

				$login = $patient->login;
				$password = $patient->password;

				if (empty($login)) {
					$cLogin = strtolower(substr($this->request["firstname"], 0, 1) . $this->request["lastname"]);
					$cLogin = ereg_replace('[^A-Za-z]', '', $cLogin);

					$loginsResponse = $this->patient->getLogins($cLogin);

					$logins = array();
					if ($loginsResponse) foreach ($loginsResponse as $login) {
						array_push($logins, $login->login);
					}

					if (in_array($cLogin, $logins)) {
						$count = 1;
						while (in_array($cLogin . $count, $logins)) {
							$count++;
						}

						$login = strtolower($cLogin . $count);
					} else {
						$login = strtolower($cLogin);
					}

					$data = array(
						'login' => $login
					);

					$this->patient->updateData(array(
						'patientid' => $this->request['ed']
					), $data);
				}

				$showWarningCellPhone = false;

				if (!empty($this->request['sendReg']) && $docPatientPortal && $this->request['use_patient_portal']) {
					if (trim($this->request['email']) != '' && trim($this->request['cell_phone']) != '') {
						sendRegistrationEmail($this->request['ed'], $this->request['email'], $login, $patient->email);
					} else {
						$showWarningCellPhone = true;
					}
				}

				$data = array(
					'date_completed' => date('Y-m-d', strtotime($this->request['copyreqdate']))
				);

				$this->flowPg2->updateData($this->request['ed'], $data);

				if ($oldReferredBy != $this->request['referred_by'] || $oldReferredSource != $this->request["referred_source"]) {
					if ($oldReferredSource == 2 && $this->request['referred_source'] == 2) {
						// PHYSICIAN -> PHYSICIAN
						// change pending letters to new referrer

						$data = array(
							'template' 			=> null,
							'md_referral_list' 	=> $this->request["referred_by"]
						);

						$this->letter->updateData(array(
							'status' 			=> 0,
							'md_referral_list' 	=> $oldReferredBy,
							'patientid' 		=> $this->request['ed']
						), $data);
					} elseif ($oldReferredSource == 1 && $this->request['referred_source'] == 1) {
						// PATIENT -> PATIENT
						// change pending letters to new referrer

						$data = array(
							'template' 			=> null,
							'md_referral_list' 	=> $this->request["referred_by"]
						);

						$this->letter->updateData(array(
							'status' 			=> 0,
							'pat_referral_list' => $oldReferredBy,
							'patientid' 		=> $this->request['ed']
						), $data);
					} elseif ($oldReferredSource == 2 && $this->request['referred_source'] != 2) {
						// PHYSICIAN -> NOT PHYSICIAN

						$letters = $this->letter->get(array(
							'md_referral_list' 	=> $oldReferredBy,
							'patientid'			=> $this->reuqest['ed'],
							'status'			=> 0
						));

						if (count($letters)) foreach ($letters as $letter) {
							deleteLetter($letter->letterid, null, 'mdReferral', $oldReferredBy);	
						}
					} elseif ($oldReferredSource == 1 && $this->request['referred_source'] != 1) {
						//PHYSICIAN -> NOT PHYSICIAN

						$letters = $this->letter->get(array(
							'pat_referral_list'	=> $oldReferredBy,
							'patientid'			=> $this->reuqest['ed'],
							'status'			=> 0
						));

						if (count($letters)) foreach ($letters as $letter) {
							deleteLetter($letter->letterid, null, 'patReferral', $oldReferredBy);	
						}
					}
				}

				$this->triggerLetter1and2($this->request['ed'], $this->request);

				if (!empty($this->request['introletter']) && $this->request['introletter'] == 1) {
					$this->triggerLetter3($this->request['ed']);
				}

				if (!empty($this->request['add_ref_but'])) {
					return redirect('add_referredby/addtopat/$patientId');
				}

				if (!empty($this->request['add_ins_but'])) {
					if (!empty($patientId)) {
						$redirect = '/pid/$patientId/type/11/ctypeeq/1/activePat/$patientId';
					}

					return redirect('add_contact/ctype/ins' . $redirect);
				}

				if (!empty($this->request['add_contact_but'])) {
					return redirect('add_patient_to/ed/$patientId');
				}

				if (!empty($this->request['sendHST'])) {
					return redirect('hst_request_co/ed/$patientId');
				}

				$message = 'Edited Successfully';

				if (!empty($this->request['sendPin'])) {
					$sendPin = '/sendPin/1';
				} else {
					$sendPin = '';
				}

				return redirect('add_patient/ed/$patientId/preview/1/addtopat/1/pid/$patientId/msg/$msg $sendPin');
			} else {
				$cLogin = strtolower(substr($this->request['firstname'], 0, 1) . $this->request['lastname']);
    			$cLogin = preg_replace('[^A-Za-z]', '', $cLogin);

    			$loginsResponse = $this->patient->getLogins($cLogin);

    			$logins = array();
				if ($loginsResponse) foreach ($loginsResponse as $login) {
					array_push($logins, $login->login);
				}

				if (in_array($cLogin, $logins)) {
					$count = 1;
					while (in_array($cLogin . $count, $logins)) {
						$count++;
					}

					$login = strtolower($cLogin . $count);
				} else {
					$login = strtolower($cLogin);
				}

				if (!empty($this->request['ssn'])) {
					$salt = Password::createSalt();
					$password = preg_replace('/\D/', '', $this->request['ssn']);
					$password = Password::genPassword($password , $salt);
				} else {
					$salt = '';
					$password = '';
				}

				$data = array(
					'firstname' 				=> ucfirst($this->request['firstname']),
					'lastname' 					=> ucfirst($this->request['lastname']),
					'middlename' 				=> ucfirst($this->request['middlename']),
					'preferred_name' 			=> $this->request['preferred_name'],
					'login'						=> $login,
					'salt'						=> $salt,
					'password'					=> $password,
					'salutation' 				=> $this->request['salutation'],
					'member_no' 				=> $this->request['member_no'],
					'group_no' 					=> $this->request['group_no'],
					'plan_no' 					=> $this->request['plan_no'], 
					'add1' 						=> $this->request['add1'], 
					'add2' 						=> $this->request['add2'], 
					'city' 						=> $this->request['city'], 
					'state' 					=> $this->request['state'], 
					'zip' 						=> $this->request['zip'], 
					'dob' 						=> $this->request['dob'], 
					'gender' 					=> $this->request['gender'], 
					'marital_status' 			=> $this->request['marital_status'],
					'ssn' 						=> $this->num($this->request['ssn'], false), 
					'feet'						=> $this->request['feet'],
					'inches'					=> $this->request['inches'],
					'weight'					=> $this->request['weight'],
					'bmi'						=> $this->request['bmi'],
					'home_phone' 				=> $this->num($this->request['home_phone']), 
					'work_phone' 				=> $this->num($this->request['work_phone']), 
					'cell_phone' 				=> $this->num($this->request['cell_phone']),
					'best_time' 				=> $this->request['best_time'],
					'best_number' 				=> $this->request['best_number'],
					'email' 					=> $this->request['email'],
					'patient_notes' 			=> $this->request['patient_notes'], 
					'p_d_party' 				=> $this->request['p_d_party'], 
					'p_d_relation' 				=> $this->request['p_d_relation'], 
					'p_d_other' 				=> $this->request['p_d_other'], 
					'p_d_employer' 				=> $this->request['p_d_employer'], 
					'p_d_ins_co' 				=> $this->request['p_d_ins_co'], 
					'p_d_ins_id' 				=> $this->request['p_d_ins_id'], 
					's_d_party' 				=> $this->request['s_d_party'], 
					's_d_relation' 				=> $this->request['s_d_relation'], 
					's_d_other' 				=> $this->request['s_d_other'], 
					's_d_employer' 				=> $this->request['s_d_employer'], 
					's_d_ins_co' 				=> $this->request['s_d_ins_co'], 
					's_d_ins_id' 				=> $this->request['s_d_ins_id'], 
					'p_m_partyfname' 			=> $this->request['p_m_partyfname'],
					'p_m_partymname' 			=> $this->request['p_m_partymname'],
					'p_m_partylname' 			=> $this->request['p_m_partylname'],
					'p_m_gender' 				=> $this->request['p_m_gender'],
					'p_m_ins_grp' 				=> $this->request['p_m_ins_grp'],
					's_m_ins_grp' 				=> $this->request['s_m_ins_grp'],
					'p_m_dss_file' 				=> $this->request['p_m_dss_file'],
					's_m_dss_file' 				=> $this->request['s_m_dss_file'],
					'p_m_same_address' 			=> $this->request['p_m_same_address'],
					's_m_same_address' 			=> $this->request['s_m_same_address'],
					'p_m_address' 				=> $this->request['p_m_address'],
					'p_m_city' 					=> $this->request['p_m_city'],
					'p_m_state' 				=> $this->request['p_m_state'],
					'p_m_zip' 					=> $this->request['p_m_zip'],
					's_m_address' 				=> $this->request['s_m_address'],
					's_m_city' 					=> $this->request['s_m_city'],
					's_m_state' 				=> $this->request['s_m_state'],
					's_m_zip' 					=> $this->request['s_m_zip'],
					'p_m_ins_type' 				=> $this->request['p_m_ins_type'],
					's_m_ins_type' 				=> $this->request['s_m_ins_type'],
					'p_m_ins_ass' 				=> $this->request['p_m_ins_ass'],
					's_m_ins_ass' 				=> $this->request['s_m_ins_ass'],
					'ins_dob' 					=> $this->request['ins_dob'],
					'ins2_dob' 					=> $this->request['ins2_dob'],
					'p_m_relation' 				=> $this->request['p_m_relation'], 
					'p_m_other' 				=> $this->request['p_m_other'], 
					'p_m_employer' 				=> $this->request['p_m_employer'], 
					'p_m_ins_co' 				=> $this->request['p_m_ins_co'], 
					'p_m_ins_id' 				=> $this->request['p_m_ins_id'], 
					'p_m_eligible_payer_id' 	=> $PMEligiblePayerId,
					'p_m_eligible_payer_name' 	=> $PMEligiblePayerName,
					'has_s_m_ins' 				=> $this->request['s_m_ins'],
					's_m_partyfname' 			=> $this->request['s_m_partyfname'],
					's_m_partymname' 			=> $this->request['s_m_partymname'],
					's_m_partylname' 			=> $this->request['s_m_partylname'], 
					's_m_gender' 				=> $this->request['s_m_gender'],
					's_m_relation' 				=> $this->request['s_m_relation'], 
					's_m_other' 				=> $this->request['s_m_other'], 
					's_m_employer' 				=> $this->request['s_m_employer'], 
					's_m_ins_co' 				=> $this->request['s_m_ins_co'], 
					's_m_ins_id' 				=> $this->request['s_m_ins_id'],
					'p_m_ins_plan' 				=> $this->request['p_m_ins_plan'],
					's_m_ins_plan' 				=> $this->request['s_m_ins_plan'], 
					'employer' 					=> $this->request['employer'], 
					'emp_add1' 					=> $this->request['emp_add1'], 
					'emp_add2' 					=> $this->request['emp_add2'], 
					'emp_city' 					=> $this->request['emp_city'], 
					'emp_state' 				=> $this->request['emp_state'], 
					'emp_zip' 					=> $this->request['emp_zip'], 
					'emp_phone' 				=> $this->num($this->request['emp_phone']), 
					'emp_fax' 					=> $this->num($this->request['emp_fax']), 
					'plan_name' 				=> $this->request['plan_name'], 
					'group_number' 				=> $this->request['group_number'], 
					'ins_type' 					=> $this->request['ins_type'], 
					'accept_assignment' 		=> $this->request['accept_assignment'], 
					'print_signature' 			=> $this->request['print_signature'], 
					'medical_insurance' 		=> $this->request['medical_insurance'], 
					'mark_yes' 					=> $this->request['mark_yes'],
					'inactive' 					=> $this->request['inactive'],
					'partner_name' 				=> $this->request['partner_name'],
					'docsleep' 					=> $this->request['docsleep'],
					'docpcp' 					=> $this->request['docpcp'],
					'mark_yes' 					=> $this->request['mark_yes'],
					'docdentist'				=> $this->request['docdentist'],
					'docent' 					=> $this->request['docent'],
					'docmdother' 				=> $this->request['docmdother'],
					'docmdother2' 				=> $this->request['docmdother2'],
					'docmdother3' 				=> $this->request['docmdother3'],
					'emergency_name' 			=> $this->request['emergency_name'],
					'emergency_relationship' 	=> $this->request['emergency_relationship'],
					'emergency_number' 			=> $this->num($this->request['emergency_number']),
					'docent'	 				=> $this->request['docent'],
					'emergency_name' 			=> $this->request['emergency_name'],
					'emergency_number' 			=> $this->num($this->request['emergency_number']),
					'referred_source' 			=> $this->request['referred_source'],
					'referred_by' 				=> $this->request['referred_by'],
					'referred_notes' 			=> $this->request['referred_notes'],
					'copyreqdate' 				=> $this->request['copyreqdate'],
					'status' 					=> $this->request['status'],
					'use_patient_portal' 		=> $this->request['use_patient_portal'],
					'ip_address'				=> Request::ip(),
					'preferredcontact' 			=> $this->request['preferredcontact']
				);

				$insertedPatientId = $this->patient->insertData($data);

				if (!empty($this->request['location'])) {
					$data = array(
						'location' 	=> $this->request['location'],
						'patientid' => $this->request['pid']
					);

					$this->summary->insertData($data);
				}

				$this->triggerLetter1and2($insertedPatientId);

				if (!empty($this->request['sendReg']) && $docPatientPortal && $this->request['use_patient_portal']) {
					if (trim($this->request['email']) != '' && trim($this->request['cell_phone']) != '') {
						sendRegistrationEmail($insertedPatientId, $this->request['email'], $login);
					} else {
						$showWarningCellPhone = true;
					}
				}

				if (!empty($this->request['introletter']) && $this->request['introletter'] == 1) {
					$this->triggerLetter3($this->request['ed']);
				}

				$data = array(
					'id' 			=> null,
					'copyreqdate' 	=> $this->request['copyreqdate'],
					'pid' 			=> $insertedPatientId
				);

				$insertedFlowPg1Id = $this->flowPg1->insertData($data);

				if (!empty($insertedFlowPg1Id)) {
					// code...
				} else {
					if (!empty($referredByQuery)) {
						$referredResult = $db->query($referredByQuery);
						$message = 'Successfully updated flowsheet!2';
					}
				}

				$stepId = '1';
				$segmentId = '1';
				$scheduled = strtotime(!empty($copyReqDate) ? $copyReqDate : '');
				$genDate = date('Y-m-d H:i:s', strtotime($this->request['copyreqdate']));

				$data = array(
					'patientid' 		=> $insertedPatientId,
					'stepid' 			=> $stepId,
					'segmentid' 		=> $segmentId,
					'date_scheduled' 	=> $scheduled,
					'date_completed' 	=> $genDate
				);

				$insertedFlowPg2InfoId = $this->flowPg2Info->insertData($data);

				if (empty($insertedFlowPg2InfoId)) {
					$message = "Error inserting Initial Contact Information to Flowsheet Page 2";
				}

				$similarPatients = $this->similarPatients($insertedPatientId);

				if (count($similarPatients)) {
					return redirect('duplicate_patients/pid/$insertedPatientId');
				} else {
					$message = 'Patient' . $this->request['firstname'] . ' ' . $this->request['lastname'] . ' added Successfully';

					if (!empty($this->request['sendPin'])) {
						$sendPin = '/sendPin/1';
					} else {
						$sendPin = '';
					}

					return redirect('add_patient/pid/' . $insertedPatientId. '/ed/' . $insertedPatientId . '/addtopat/1' . $sendPin);
				}
			}
		}

		$requestEd = (!empty($this->request['ed'])) ? $this->request['ed'] : '-1';

		$status = Constants::DSS_PREAUTH_PENDING . ',' . Constants::DSS_PREAUTH_PREAUTH_PENDING;

		$vob = $this->insurancePreauth->get(array(
			'patient_id' => $requestEd
		), $status, 'front_office_request_date');

		$pendingVob = count($vob);

		if ($pendingVob) {
			$vob = $vob[0];
			$pendingVobStatus = $vob->status;
		}

		$patient = $this->patient->get(array(
			'patientid' => $requestEd
		));

		$patient = count($patient) ? $patient[0] : null;

		if (!empty($message)) {
			$firstname = $this->request['firstname'];
			$middlename = $this->request['middlename'];
			$lastname = $this->request['lastname'];
			$preferred_name = $this->request['preferred_name'];
			$salutation = $this->request['salutation'];
			$login = $this->request['login'];
			$member_no = $this->request['member_no'];
			$group_no = $this->request['group_no'];
			$plan_no = $this->request['plan_no'];
			$dob = $this->request['dob'];
			$add1 = $this->request['add1'];
			$add2= $this->request['add2'];
			$city = $this->request['city'];
			$state = $this->request['state'];
			$zip = $this->request['zip'];
			$gender = $this->request['gender'];
			$marital_status = $this->request['marital_status'];
			$ssn = $this->request['ssn'];
			$feet = $this->request['feet'];
			$inches = $this->request['inches'];
			$weight = $this->request['weight'];
			$bmi = $this->request['bmi'];
			$home_phone = $this->request['home_phone'];
			$work_phone = $this->request['work_phone'];
			$cell_phone = $this->request['cell_phone'];
			$best_time = $this->request['best_time'];
			$best_number = $this->request['best_number'];
			$email = $this->request['email'];
			$patient_notes = $this->request['patient_notes'];
			$p_d_party = $this->request["p_d_party"]; 
			$p_d_relation = $this->request["p_d_relation"];
			$p_d_other = $this->request["p_d_other"];
			$p_d_employer = $this->request["p_d_employer"];
			$p_d_ins_co = $this->request["p_d_ins_co"];
			$p_d_ins_id = $this->request["p_d_ins_id"];
			$s_d_party = $this->request["s_d_party"]; 
			$s_d_relation = $this->request["s_d_relation"];
			$s_d_other = $this->request["s_d_other"];
			$s_d_employer = $this->request["s_d_employer"];
			$s_d_ins_co = $this->request["s_d_ins_co"];
			$s_d_ins_id = $this->request["s_d_ins_id"];
			$p_m_partyfname = $this->request["p_m_partyfname"];
			$p_m_partymname = $this->request["p_m_partymname"];
			$p_m_partylname = $this->request["p_m_partylname"]; 
			$p_m_gender = $this->request['p_m_gender'];
			$p_m_relation = $this->request["p_m_relation"];
			$p_m_other = $this->request["p_m_other"];
			$p_m_employer = $this->request["p_m_employer"];
			$p_m_ins_co = $this->request["p_m_ins_co"];
			$p_m_ins_id = $this->request["p_m_ins_id"];
			$p_m_ins_payer_id = $this->request['p_m_ins_payer_id'];
			$has_s_m_ins = $this->request["s_m_ins"];
			$s_m_partyfname = $this->request["s_m_partyfname"];
			$s_m_partymname = $this->request["s_m_partymname"];
			$s_m_partylname = $this->request["s_m_partylname"];  
			$s_m_gender = $this->request['s_m_gender'];
			$s_m_relation = $this->request["s_m_relation"];
			$s_m_other = $this->request["s_m_other"];
			$s_m_employer = $this->request["s_m_employer"];
			$s_m_ins_co = $this->request["s_m_ins_co"];
			$s_m_ins_id = $this->request["s_m_ins_id"];
			$p_m_ins_grp = $this->request["p_m_ins_grp"];
			$s_m_ins_grp = $this->request["s_m_ins_grp"];
			$p_m_dss_file = $this->request["p_m_dss_file"];
			$s_m_dss_file = $this->request["s_m_dss_file"];
			$p_m_same_address = $this->request["p_m_same_address"];
			$s_m_same_address = $this->request["s_m_same_address"];
			$p_m_address = $this->request["p_m_address"];
			$p_m_city = $this->request["p_m_city"];
			$p_m_state = $this->request["p_m_state"];
			$p_m_zip = $this->request["p_m_zip"];
			$s_m_address = $this->request["s_m_address"];
			$s_m_city = $this->request["s_m_city"];
			$s_m_state = $this->request["s_m_state"];
			$s_m_zip = $this->request["s_m_zip"];
			$p_m_ins_type = $this->request["p_m_ins_type"];
			$s_m_ins_type = $this->request["s_m_ins_type"];
			$p_m_ins_ass = $this->request["p_m_ins_ass"];
			$s_m_ins_ass = $this->request["s_m_ins_ass"];
			$p_m_ins_plan = $this->request["p_m_ins_plan"];
			$s_m_ins_plan = $this->request["s_m_ins_plan"];
			$ins_dob = $this->request["ins_dob"];
			$ins2_dob = $this->request["ins2_dob"];
			$employer = $this->request["employer"];
			$emp_add1 = $this->request["emp_add1"];
			$emp_add2 = $this->request["emp_add2"];
			$emp_city = $this->request["emp_city"];
			$emp_state = $this->request["emp_state"];
			$emp_zip = $this->request["emp_zip"];
			$emp_phone = $this->request["emp_phone"];
			$docsleep = $this->request["docsleep"];
			$docpcp = $this->request["docpcp"];
			$docdentist = $this->request["docdentist"];
			$docent = $this->request["docent"];
			$docmdother = $this->request["docmdother"];
			$docmdother2 = $this->request["docmdother2"];
			$docmdother3 = $this->request["docmdother3"];
			$emp_fax = $this->request["emp_fax"];
			$plan_name = $this->request["plan_name"];
			$group_number = $this->request["group_number"];
			$ins_type = $this->request["ins_type"];
			$status = $this->request["status"];
			$use_patient_portal = $this->request["use_patient_portal"];
			$accept_assignment = $this->request["accept_assignment"];
			$print_signature = $this->request["print_signature"];
			$medical_insurance = $this->request["medical_insurance"];
			$mark_yes = $this->request["mark_yes"];
			$inactive = $this->request["inactive"];
			$partner_name = $this->request["partner_name"];
			$emergency_name = $this->request["emergency_name"];
			$emergency_relationship = $this->request["emergency_relationship"];
			$emergency_number = $this->request["emergency_number"];
			$referred_source = $this->request["referred_source"];
			$referred_by = $this->request["referred_by"];
			$referred_notes = $this->request["referred_notes"];
			$copyreqdate = $this->request["copyreqdate"];
			$preferredcontact = $this->request["preferredcontact"];
			$location = $this->request["location"];
		} else {
			if (!empty($patient)) {
				$firstname = $patient->firstname;
				$middlename = $patient->middlename;
				$lastname = $patient->lastname;
				$preferred_name = $patient->preferred_name;
				$salutation = $patient->salutation;
				$login = $patient->login;
				$member_no = $patient->member_no;
				$group_no = $patient->group_no;
				$plan_no = $patient->plan_no;
				$dob = $patient->dob;
				$add1 = $patient->add1;
				$add2 = $patient->add2;
				$city = $patient->city;
				$state = $patient->state;
				$zip = $patient->zip;
				$gender = $patient->gender;
				$marital_status = $patient->marital_status;
				$ssn = $patient->ssn;
				$feet = $patient->feet;
				$inches = $patient->inches;
				$weight = $patient->weight;
				$bmi = $patient->bmi;
				$home_phone = $patient->home_phone;
				$work_phone = $patient->work_phone;
				$cell_phone = $patient->cell_phone;
				$best_time = $patient->best_time;
				$best_number = $patient->best_number;
				$email = $patient->email;
				$patient_notes = $patient->patient_notes;
				$p_d_party = $patient->p_d_party; 
				$p_d_relation = $patient->p_d_relation;
				$p_d_other = $patient->p_d_other;
				$p_d_employer = $patient->p_d_employer;
				$p_d_ins_co = $patient->p_d_ins_co;
				$p_d_ins_id = $patient->p_d_ins_id;
				$s_d_party = $patient->s_d_party; 
				$s_d_relation = $patient->s_d_relation;
				$s_d_other = $patient->s_d_other;
				$s_d_employer = $patient->s_d_employer;
				$s_d_ins_co = $patient->s_d_ins_co;
				$s_d_ins_id = $patient->s_d_ins_id;
				$p_m_partyfname = $patient->p_m_partyfname;
				$p_m_partymname = $patient->p_m_partymname;
				$p_m_partylname = $patient->p_m_partylname;
				$p_m_relation = $patient->p_m_relation;
				$p_m_gender = $patient->p_m_gender;
				$p_m_other = $patient->p_m_other;
				$p_m_employer = $patient->p_m_employer;
				$p_m_ins_co = $patient->p_m_ins_co;
				$p_m_ins_id = $patient->p_m_ins_id;
				$p_m_eligible_payer_id = $patient->p_m_eligible_payer_id;
				$p_m_eligible_payer_name = $patient->p_m_eligible_payer_name;
				$s_m_eligible_payer_id = $patient->s_m_eligible_payer_id;
				$s_m_eligible_payer_name = $patient->s_m_eligible_payer_name;
				$has_s_m_ins = $patient->has_s_m_ins;
				$s_m_partyfname = $patient->s_m_partyfname;
				$s_m_partymname = $patient->s_m_partymname;
				$s_m_partylname = $patient->s_m_partylname;
				$s_m_gender = $patient->s_m_gender;
				$s_m_relation = $patient->s_m_relation;
				$s_m_other = $patient->s_m_other;
				$s_m_employer = $patient->s_m_employer;
				$s_m_ins_co = $patient->s_m_ins_co;
				$s_m_ins_id = $patient->s_m_ins_id;
				$p_m_ins_grp = $patient->p_m_ins_grp;
				$s_m_ins_grp = $patient->s_m_ins_grp;
				$p_m_dss_file = $patient->p_m_dss_file;
				$s_m_dss_file = $patient->s_m_dss_file;
				$p_m_same_address = $patient->p_m_same_address;
				$s_m_same_address = $patient->s_m_same_address;
				$p_m_address = $patient->p_m_address;
				$p_m_city = $patient->p_m_city;
				$p_m_state = $patient->p_m_state;
				$p_m_zip = $patient->p_m_zip;
				$s_m_address = $patient->s_m_address;
				$s_m_city = $patient->s_m_city;
				$s_m_state = $patient->s_m_state;
				$s_m_zip = $patient->s_m_zip;
				$p_m_ins_type = $patient->p_m_ins_type;
				$s_m_ins_type = $patient->s_m_ins_type;
				$p_m_ins_ass = $patient->p_m_ins_ass;
				$s_m_ins_ass = $patient->s_m_ins_ass;
				$p_m_ins_plan = $patient->p_m_ins_plan;
				$s_m_ins_plan = $patient->s_m_ins_plan;
				$ins_dob = $patient->ins_dob;
				$ins2_dob = $patient->ins2_dob;
				$employer = $patient->employer;
				$emp_add1 = $patient->emp_add1;
				$emp_add2 = $patient->emp_add2;
				$emp_city = $patient->emp_city;
				$emp_state = $patient->emp_state;
				$emp_zip = $patient->emp_zip;
				$emp_phone = $patient->emp_phone;
				$emp_fax = $patient->emp_fax;
				$plan_name = $patient->plan_name;
				$group_number = $patient->group_number;
				$ins_type = $patient->ins_type;
				$status = $patient->status;
				$use_patient_portal = $patient->use_patient_portal;
				$accept_assignment = $patient->accept_assignment;
				$print_signature = $patient->print_signature;
				$medical_insurance = $patient->medical_insurance;
				$mark_yes = $patient->mark_yes;
				$docsleep = $patient->docsleep;
			}

			if (!empty($docsleep) && $docsleep != 'Not Set') {
				$contact = $this->contact->getDocsleep($docsleep);

				$docsleepName = $contact->lastname . ', ' . $contact->firstname . ' ' . (($contact->contacttype != '') ? ' - ' . $contact->contacttype : '');
			} else {
				$docsleepName = '';
			}

			$docpcp = !empty($patient) ? $patient->docpcp : null;
			if ($docpcp && $docpcp != 'Not Set') {
				$contact = $this->contact->getDocsleep($docpcp);

				$docpcpName = $contact->lastname . ', ' . $contact->firstname . ' ' . $contact->middlename . (($contact->contacttype != '') ? ' - ' . $contact->contacttype : '');
			} else {
				$docpcpName = '';
			}

			$docdentist = !empty($patient) ? $patient->docdentist : null;
			if ($docdentist && $docdentist != 'Not Set') {
				$contact = $this->contact->getDocsleep($docdentist);

				$docdentistName = $contact->lastname . ', ' . $contact->firstname . ' ' . $contact->middlename . (($contact->contacttype != '') ? ' - ' . $contact->contacttype : '');
			} else {
				$docdentistName = '';
			}

			$docent = !empty($patient) ? $patient->docent : null;
			if ($docent && $docent != 'Not Set') {
				$contact = $this->contact->getDocsleep($docent);

				$docentName = $contact->lastname . ', ' . $contact->firstname . ' ' . $contact->middlename . (($contact->contacttype != '') ? ' - ' . $contact->contacttype : '');
			} else {
				$docentName = '';
			}

			$docmdother = !empty($patient) ? $patient->docmdother : null;
			if ($docmdother && $docmdother != 'Not Set') {
				$contact = $this->contact->getDocsleep($docmdother);

				$docmdotherName = $contact->lastname . ', ' . $contact->firstname . ' ' . $contact->middlename . (($contact->contacttype != '') ? ' - ' . $contact->contacttype : '');
			} else {
				$docmdotherName = '';
			}

			$docmdother2 = !empty($patient) ? $patient->docmdother2 : null;
			if ($docmdother2 && $docmdother2 != 'Not Set') {
				$contact = $this->contact->getDocsleep($docmdother2);

				$docmdother2Name = $contact->lastname . ', ' . $contact->firstname . ' ' . $contact->middlename . (($contact->contacttype != '') ? ' - ' . $contact->contacttype : '');
			} else {
				$docmdother2Name = '';
			}

			$docmdother3 = !empty($patient) ? $patient->docmdother3 : null;
			if ($docmdother3 && $docmdother3 != 'Not Set') {
				$contact = $this->contact->getDocsleep($docmdother3);

				$docmdother3Name = $contact->lastname . ', ' . $contact->firstname . ' ' . $contact->middlename . (($contact->contacttype != '') ? ' - ' . $contact->contacttype : '');
			} else {
				$docmdother3Name = '';
			}

			if (!empty($patient)) {
				$inactive 				= $patient->inactive;
				$partnerName 			= $patient->partner_name;
				$emergencyName 			= $patient->emergency_name;
				$emergencyrelationship 	= $patient->emergency_relationship;
				$emergencyNumber 		= $patient->emergency_number;
				$referredSource 		= $patient->referred_source;
				$referredBy 			= $patient->referred_by;
				$referredNotes 			= $patient->referred_notes;
			}

			if (isset($referredSource)) {
				if ($referredSource == Constants::DSS_REFERRED_PATIENT) {
					$patient = $this->patient->get(array(
						'patientid' => $referredBy
					));

					$referredName = $patient->lastname . ', ' . $patient->firstname . ' ' . $patient->middlename . ' - Patient';
				} elseif ($referredSource == Constants::DSS_REFERRED_PHYSICIAN) {
					$contact = $this->contact->getDocsleep($referredBy);

					$referredName = $contact->lastname . ', ' . $contact->firstname . ' ' . $contact->middlename;
					if (!empty($contact->contacttype)) {
						$referredName .= ' - ' . $contact->contacttype;
					}
				}
			}

			if (!empty($patient)) {
				$copyReqDate = $patient->copyreqdate;
				$preferredContact = $patient->preferredcontact;
				$referredNotes = $patient->referred_notes;
				$name = $patient->lastname . ' ' . $patient->middlename . ', ' . $patient->firstname;
			}

			$summary = $this->summary->get($patientId);

			if (count($summary)) {
				$summary = $summary[0];
				$location = $summary->location;
			}

			$butText = 'Add ';
		}

		if (!empty($patient->userid)) {
			$butText = 'Save/Update ';
		} else {
			$butText = 'Add ';
		}

		// Check if required information is filled out
		$complete_info = 0;
		if (!empty($home_phone) || !empty($work_phone) || !empty($cell_phone)) {
			$patientphone = true;
		}

		if (!empty($email)) {
			$patientemail = true;
		}

		if ((!empty($patientemail) || !empty($patientphone)) && !empty($add1) && !empty($city) && !empty($state) && !empty($zip) && !empty($dob) && !empty($gender)) {
			$complete_info = 1;
		}

		// Determine Whether Patient Info has been set
		if (!empty($this->request['ed'])) {
			$this->updatePatientSummary($this->request['ed'], 'patient_info', $complete_info);
		}

		/**

		*/
		// CODE FOR VIEW
		/**

		*/

		$showBlock = array();

		$notifications = $this->findPatientNotifications($patientId);

		if (!empty($this->request['search'])) {
			if (strpos($this->request['search'], ' ')) {
				$firstname = ucfirst(substr($this->request['search'], 0, strpos($this->request['search'], ' ')));
    			$lastname = ucfirst(substr($this->request['search'], strpos($this->request['search'],' ') + 1));
			} else {
				$firstname = ucfirst($this->request['search']);
			}
		}

		if (!empty($docPatientPortal) && $docPatientPortal && !empty($usePatientPortal) && $usePatientPortal) {
			if ($patient->registration_status == 1 || $patient->registration_status == 0) {
				$showBlock['buttonSendReg'] = true;
			} else {
				$showBlock['buttonSendReg'] = false;
			}
		}

		$companies = $this->company->getJoin(Session::get('docId'), Constants::DSS_COMPANY_TYPE_HST);

		if (count($companies)) {
			if (!empty($patHstNumUncompleted) && $patHstNumUncompleted > 0) {
				$showBlock['orderHst'] = true;
			} else {
				$showBlock['orderHst'] = false;
			}
		}

		$imageType4 = $this->qImage->getImage(4, $patientId, 'adddate');

		if (count($imageType4) == 0) {
			$showBlock['patientPhoto'] = true;
		} else {
			$showBlock['patientPhoto'] = false;
		}

		$registrationStatus = !empty($patient) ? $patient->registration_status : null;

		if (!empty($patient) && $patient->use_patient_portal == 1) {
			switch ($registrationStatus) {
				case 0:
					$showBlock['registrationStatus'] = 'Unregistered';
					break;
				case 1:
					$showBlock['registrationStatus'] = 'Registration Emailed ' . date('m/d/Y h:i a', strtotime($patient->registration_senton)) . ' ET';
					break;
				case 2:
					$showBlock['registrationStatus'] = 'Registered';
					break;
			}
		} else {
			$showBlock['registrationStatus'] = 'Patient Portal In-active';
		}

		$locations = $this->location->get(array(
			'docid' => Session::get('docId')
		));

		if (empty($patientId)) {
			$copyReqDate = date('m/d/Y');
		}

		$user = $this->user->findUser(Session::get('docId'));

		if ($user->use_eligible_api == 1) {
			$showBlock['insuranceCo'] = true;
		} else {
			$showBlock['insuranceCo'] = false;
		}

		$imageType10 = $this->qImage->getImage(10, $patientId, 'adddate');

		if (count($imageType10) == 0) {
			$showBlock['insuranceCardImage10'] = false;
		} else {
			$showBlock['insuranceCardImage10'] = true;
			$image = $imageType10[0];
		}

		$insuranceContacts = $this->contact->getInsContact(Session::get('docId'));

		$imageType12 = $this->qImage->getImage(12, $patientId, 'adddate');

		if (count($imageType12) == 0) {
			$showBlock['insuranceCardImage12'] = false;
		} else {
			$showBlock['insuranceCardImage12'] = true;
			$image = $imageType12[0];
		}

		if (!empty($docPatientPortal)) {
			$showBlock['portalStatus'] = true;
		} else {
			$showBlock['portalStatus'] = false;
		}

		$letter = $this->letter->get(array(
			'templateid' 	=> 3,
			'deleted' 		=> 0,
			'patientid' 	=> $patientId
		), 'generated_date');

		if (count($letter) == 0) {
			$showBlock['introLetter'] = false;
		} else {
			$letter = $letter[0];
			$showBlock['introLetter'] = 'DSS Intro Letter Sent to Patient ' . $letter->generated_date;
		}

		if (empty($this->request['noheaders'])) {
			$showBlock['noHeaders'] = true;
		}

		if (!empty($this->request['readonly'])) {
			$showBlock['readOnly'] = true;
		}
	}

	/**



	*/

	private function triggerLetter1and2($patientId, $request)
	{
		$user = $this->user->findUser(Session::get('docId'));

		if ($user->use_letters && $user->intro_letters) {
			$letter1Id = '1';
			$letter2Id = '2';
			$mdContacts = array();

			$mdcontacts[] = $request['docsleep'];
			$mdcontacts[] = $request['docpcp'];
			$mdcontacts[] = $request['docdentist'];
			$mdcontacts[] = $request['docent'];
			$mdcontacts[] = $request['docmdother'];
			$mdcontacts[] = $request['docmdother2'];
			$mdcontacts[] = $request['docmdother3'];

			$recipients = array();
			foreach ($mdcontacts as $contact) {
				if ($contact != 'Not Set') {
					$mdList = $this->letter->getMdList($contact, $letter1id, $letter2id);

					$numMdList = count($mdList);

					if (empty($numMdList)) {
						return 'Error Selecting Letters from Database';
					}

					if ($numMdList == 0 && $contact != '') {
						$contact = $this->contact->get(array(
							'contactid' => $contact,
							'status' 	=> 1
						));

						if (count($contact)) {
							$recipients[] = $contact;
						}
					}
				}
			}

			if (count($recipients)) {
				$recipientsList = implode(',', $recipients);
				$letter2 = $this->createLetter($letter2id, $patientId, '', '', $recipientsList);

				if (Session::get('userType') != Constants::DSS_USER_TYPE_SOFTWARE) {
					$letter1 = $this->createLetter($letter1id, $patientId, '', '', $recipientsList);

					if (!is_numeric($letter1)) {
						return $letter1;
					}
				}

				if (!is_numeric($letter2)) {
					return $letter2;
				}
			}
		}
	}

	private function triggerLetter3($patientId)
	{
		$letterId = '3';
		$toPatient = '1';

		$letter = $this->createLetter($letterid, $pid, '', $topatient);

		return $letter;
	}

	private function sendRegistrationEmail($patientId, $email, $login, $oldEmail = '')
	{
		$patient = $this->patient->get(array(
			'patientid' => $patientId
		))[0];

		if ($patient->recover_hash == '' || $e != $oldEmail) {
			$recoverHash = hash('sha256', $patient->patientid . $patient->email . rand());
			$data = array(
				'text_num' 				=> 0,
				'access_type' 			=> 1,
				'text_date' 			=> date('Y-m-d H:i:s'),
				'access_code' 			=> '',
				'registration_senton' 	=> date('Y-m-d H:i:s'),
				'registration_status' 	=> 1,
				'recover_hash' 			=> $recoverHash,
				'recover_time' 			=> date('Y-m-d H:i:s')
			);

			$this->patient->updateData(array(
				'patientid' => $patient->patientId
			), $data);
		} else {
			$data = array(
				'access_type' 			=> 1,
				'registration_senton' 	=> date('Y-m-d H:i:s'),
				'registration_status' 	=> 1
			);

			$this->patient->updateData(array(
				'patientid' => $patient->patientId
			), $data);

			$recoverHash = $patient->recover_hash;
		}

		// not used anywhere
		/*
		$location = $this->user->getLocation(array(
			'p.patientid' => $patient->patientid
		), true);
		*/

		$location = $this->summary->get($patient->patientid)[0];

		if (!empty($location->location)) {
			$location = $this->user->getLocation(array(
				'l.id' 		=> $location->location,
				'l.docid' 	=> $patient->docid
			));
		} else {
			$location = $this->user->getLocation(array(
				'p.patientid' => $patient->patientid
			), true);
		}

		$mailingPhone = $location->mailing_phone;

		if ($location->user_type == Constants::DSS_USER_TYPE_SOFTWARE) {
			$logo = "/manage/q_file/" . $location->logo;
		} else {
			$logo = "/reg/images/email/reg_logo.gif";
		}

		$from = "Dental Sleep Solutions <patient@dentalsleepsolutions.com>";
		$mimeBoundary = 'Multipart_Boundary_x' . md5(time()) . 'x';

		$headers = 'From: "Dental Sleep Solutions" <Patient@dentalsleepsolutions.com>' . "\n"; 
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
		$headers .= "Content-Transfer-Encoding: 7bit\n";
		$headers .= 'X-Mailer: PHP/' . phpversion();

		$subject = "Online Patient Registration";

		// write code for send email
		// ----- mail -----
		/**

		*/
	}

	private function sendReminderEmail($patientId, $email)
	{
		$patient = $this->patient->get(array(
			'patientid' => $patientId
		))[0];

		$location = $this->summary->get($patient->patientid)[0];

		if (!empty($location->location)) {
			$location = $this->user->getLocation(array(
				'l.id' 		=> $location->location,
				'l.docid' 	=> $patient->docid
			));
		} else {
			$location = $this->user->getLocation(array(
				'p.patientid' => $patient->patientid
			), true);
		}

		$mailingPhone = $location->mailing_phone;

		if ($location->user_type == Constants::DSS_USER_TYPE_SOFTWARE) {
			$logo = "/manage/q_file/" . $location->logo;
		} else {
			$logo = "/reg/images/email/reg_logo.gif";
		}

		$headers = 'From: Dental Sleep Solutions <patient@dentalsleepsolutions.com>' . "\r\n"
				 . 'Content-type: text/html' . "\r\n"
				 . 'Reply-To: patient@dentalsleepsolutions.com' . "\r\n"
				 . 'X-Mailer: PHP/' . phpversion();

		$subject = "Online Patient Registration";

		// write code for send email
		// ----- mail -----
		/**

		*/
	}

	private function num($n, $phone = true)
	{
		$n = preg_replace('/\D/', '', $n);

		if (!$phone) {
			return $n;
		}

		$pattern = '/([1]*)(.*)/'; 
		preg_match($pattern, $n, $matches);

		return $matches[2];
	}

	private function createVob($patientId)
	{
		$e0486 = (count($this->patient->getTransactionCode0486($patientId)) > 0);

		$userInfo = (count($this->patient->getUserInfo($patientId)) > 0);

		if (!$e0486 && !$userInfo) {
			return 'e0486_user';
		} elseif (!$e0486) {
			return 'e0486';
		} elseif (!$userInfo) {
			return 'user';
		}

		$patient = $this->patient->preauthPatient($patientId);

		$sleepStudy = $this->summSleeplab->preauthSleepStudy($patientId);

		$diagnosis = $sleepStudy->diagnosis;

		$data = array(
			'patient_id'				=> $patientId,
			'doc_id'					=> $patient->doc_id,
			'ins_co'					=> $patient->ins_co,
			'ins_rank'					=> $patient->ins_rank,
			'ins_phone'					=> $patient->ins_phone,
			'patient_ins_group_id'		=> $patient->patient_ins_group_id,
			'patient_ins_id'			=> $patient->patient_ins_id,
			'patient_firstname'			=> $patient->patient_firstname,
			'patient_lastname'			=> $patient->patient_lastname,
			'patient_phone'				=> $patient->patient_phone,
			'patient_add1'				=> $patient->patient_add1,
			'patient_add2'				=> $patient->patient_add2,
			'patient_city'				=> $patient->patient_city,
			'patient_state'				=> $patient->patient_state,
			'patient_zip'				=> $patient->patient_zip,
			'patient_dob'				=> $patient->patient_dob,
			'insured_first_name'		=> $patient->insured_first_name,
			'insured_last_name'			=> $patient->insured_last_name,
			'insured_dob'				=> $patient->insured_dob,
			'doc_npi'					=> $patient->doc_npi,
			'referring_doc_npi'			=> $patient->referring_doc_npi,
			'trxn_code_amount'			=> $patient->trxn_code_amount,
			'diagnosis_code'			=> $diagnosis,
			'doc_medicare_npi'			=> $patient->doc_medicare_npi,
			'doc_tax_id_or_ssn'			=> $patient->doc_tax_id_or_ssn,
			'front_office_request_date'	=> date('Y-m-d H:i:s'),
			'status'					=> Constants::DSS_PREAUTH_PENDING,
			'userid'					=> Session::get('userId'),
			'viewed'					=> 1,
			'doc_name'					=> $patient->doc_name,
			'doc_practice'				=> $patient->doc_practice,
			'doc_address'				=> $patient->doc_address,
			'doc_phone'					=> $patient->doc_phone
		);

		$insurancePreauthId = $this->insurancePreauth->insertData($data);

		return $insurancePreauthId;
	}

	private function deleteLetter($letterId, $type, $recipientId, $parent = null, $template = null)
	{
		$letter = $this->letter->get(array(
			'letterid' => $letterId
		))[0];

		$contacts = $this->getContactInfo((($patient->topatient == '1') ? $patient->patientid : ''), $patient->md_list, $patient->md_referral_list, $patient->pat_referral_list);

		$totalContacts = count(!empty($contacts->patient) ? $contacts->patient : array()) + count($contacts->mds) + count(!empty($contacts->md_referrals) ? $contacts->md_referrals : array()) + count(!empty($contacts->pat_referrals) ? $contacts->pat_referrals : array());

		if (empty($letterId)) {
			return false;
		} elseif ($totalContacts == 1) {
			$data = array(
				'parentid'		=> null,
				'deleted'		=> 1,
				'deleted_by'	=> Session::get('userId'),
				'deleted_on'	=> date('Y-m-d H:i:s')
			);

			$letterResponse = $this->letter->updateData(array(
				'letterid' => $letterId
			), $data);

			$data = array(
				'viewed' => 1
			);

			$faxResponse = $this->fax->updateData(array(
				'letterid' => $letterId
			), $data);

			$data = array(
				'parentid' => null,
			);

			$parentResponse = $this->letter->updateData(array(
				'parentid' => $letterId
			), $data);

			return $letterResponse;
		} else {
			$letter = $this->letter->get(array(
				'letterid' => $letterId
			));

			if (!empty($letter)) foreach ($letter as $attribute) {
				$deleted = '1';

				if ($type == 'patient') {
					$toPatient = '1';
					$removePatient = '0';
				} elseif ($type == 'md') {
					$mdList = $recipientId;
					$mds = explode(",", $attribute->md_list);
					$key = array_search($recipientId, $mds);
					unset($mds[$key]);
					$newMds = implode(",", $mds);
					$ccMds = explode(",", $attribute->cc_md_list);
					$ccKey = array_search($recipientId, $ccMds);
					unset($ccMds[$ccKey]);
					$newCcMds = implode(",", $ccMds);
				} elseif ($type == 'mdReferral') {
					$mdReferralList = $recipientId;
					$mdReferrals = explode(",", $attribute->md_referral_list);
					$key = array_search($recipientId, $mdReferrals);
					unset($mdReferrals[$key]);
					$newMdReferrals = implode(",", $mdReferrals);
					$ccMdReferrals = explode(",", $attribute->cc_md_referral_list);
					$ccKey = array_search($recipientId, $ccMdReferrals);
					unset($ccMdReferrals[$ccKey]);
					$newCcMdReferrals = implode(",", $ccMdReferrals);
				} elseif ($type == 'patReferral') {
					$patReferralList = $recipientId;
					$patReferrals = explode(",", $attribute->pat_referral_list);
					$key = array_search($recipientId, $patReferrals);
					unset($patReferrals[$key]);
					$newPatReferrals = implode(",", $patReferrals);
					$ccPatReferrals = explode(",", $attribute->cc_pat_referral_list);
					$ccKey = array_search($recipientId, $ccPatReferrals);
					unset($ccPatReferrals[$ccKey]);
					$newCcPatReferrals = implode(",", $ccPatReferrals);
				}

				$letter = $this->createLetter($attribute->templateid, $attribute->patientid, $attribute->info_id, $toPatient, $mdList, $mdReferralList, $patReferralList, $letterId, $template, $attribute->send_method, '', $deleted, false);
			}

			if (is_numeric($letter)) {
				if ($type == 'patient') {
					$data = array(
						'topatient'		=> $removePatient,
						'cc_topatient' 	=> $removePatient
					);					
				} elseif ($type == 'md') {
					$data = array(
						'md_list'		=> $newMds,
						'cc_md_list' 	=> $newCcMds
					);
				} elseif ($type == 'mdReferral') {
					$data = array(
						'md_referral_list'		=> $newMdReferrals,
						'cc_md_referral_list' 	=> $newCcMdReferrals
					);
				} elseif ($type == 'patReferral') {
					$data = array(
						'pat_referral_list'		=> $newPatReferrals,
						'cc_pat_referral_list' 	=> $newCcPatReferrals
					);
				}

				$letterResponse = $this->letter->updateData(array(
					'letterid' => $letterId
				), $data);

				if (!empty($letterResponse)) {
					return false;
				} else {
					return $letter;
				}
			}
		}
	}

	// Retrieve Names Salutation and more from Database
	// Returns an array of the form [patient, mds, or md_referrals][id]['fieldname']
	private function getContactInfo($patientId, $mdList, $mdReferralList, $patientReferralList = null, $letterId = 0)
	{
		$contactInfo = array();

		if (!empty($patientId)) {
			$patient = $this->patient->get(array(
				'patientid' => $patientId
			))[0];

			if (!empty($patient)) {
				foreach ($patient as $attribute) {
					$contactInfo['patient'][] = $attribute;
				}
			}
		}

		if (!empty($mdList)) {
			$contact = $this->contact->getDocsleep($mdList);

			if (!empty($contact)) {
				foreach ($contact as $attribute) {
					$contactInfo['mds'][] = $attribute;
				}
			}
		}

		if (!empty($mdReferralList)) {
			$contact = $this->contact->getDocsleep($mdReferralList);

			if (!empty($contact)) {
				foreach ($contact as $attribute) {
					$contactInfo['mdReferrals'][] = $attribute;
				}
			}
		}

		if (!empty($patientReferralList)) {
			$patient = $this->patient->get(array(
				'patientid' => $patientReferralList
			));

			if (!empty($patient)) {
				foreach ($patient as $attribute) {
					$contactInfo['patReferrals'][] = $attribute;
				}
			}
		}

		return $contactInfo;
	}

	private function similarPatients($patientId)
	{
		$patient = $this->patient->get(array(
			'patientid' => $patientId
		))[0];

		$data = array(
			'docId' 	=> Session::get('docId'),
			'firstname' => $patient->firstname,
			'lastname' 	=> $patient->lastname,
			'add1' 		=> $patient->add1,
			'city' 		=> $patient->city,
			'state' 	=> $patient->state,
			'zip' 		=> $patient->zip
		);

		$similarPatients = $this->patient->getSimilarPatients($data);

		$docs = array();
		$counter = 0;

		foreach ($similarPatients as $patient) {
			$docs[$counter]['id'] = $patient->patientid;
			$docs[$counter]['name'] = $patient->firstname . ' ' . $patient->lastname;
			$docs[$counter]['address'] = $patient->add1 . ' ' . $patient->add2 . ' ' . $patient->city . ' ' . $patient->state . ' ' . $patient->zip;
			$docs[$counter]['phone'] = (!empty($patient->phone1) ? $patient->phone1 : '');

			$counter++;
		}

		return $docs;
	}

	private function updatePatientSummary($patientId = null, $column = null, $value = null)
	{
		if (empty($patientId) || empty($column)) {
			return 0;
		}

		$insert = false;
		$patientSummary = $this->patientSummary->get(array(
			'pid' => $patientId
		));

		if (count($patientSummary) == 0) {
			$insert = true;
		}

		if ($insert) {
			$data = array(
				'pid' 	=> $patientId,
				$column => $value 
			);

			$result = $this->patientSummary->insertData($data);
		} else {
			$data = array(
				$column => $value
			);

			$result = $this->patientSummary->updateData($patientId, $data);
		}

		return $result;
	}

	private function findPatientNotifications($patientId)
	{
		$notifications = $this->notification->get(array(
			'patientid' => $patientId,
			'status'	=> 1
		));

		return $notifications;
	}

	private function createLetter($templateId, $patientId = null, $infoId = null, $toPatient = null, $mdList = null, $mdReferralList = null, $patReferralList = null, $parentId = null, $template = null, $sendMethod = null, $status = null, $deleted = null, $checkRecipient = true, $templateType = null, $ccToPatient = null, $ccMdList = null, $ccMdReferralList = null, $ccPatReferral_list = null, $fontSize = null, $fontFamily = null)
	{
		if (!empty(Session::get('docId'))) {
			$user = $this->user->findUser(Session::get('docId'));

			if ($user->use_letters != '1') {
				return -1;
			}
		}

		if ((!$toPatient && !$mdReferralList && !$mdList && !$patReferral_list) || ($checkRecipient && !$mdReferralList && !$mdList && ($templateId == 16 || $templateId == 19))) {
			$letterTemplate = $this->letterTemplate->findLetterTemplate($templateId);

			return false;
		}

		$mdArray = explode(',', $mdList);
		$mdArray = array_filter($mdArray, array(new MDReferralFilter($mdReferralList), 'isReferrer'));
		$mdList = implode(',', $mdArray);

		$genDate = date('Y-m-d H:i:s');
		if ($status == null) {
			$status = '0';
		}

		$delivered = '0';
		if ($deleted == null) {
			$deleted = '0';
		}

		$data = array();

		if (!isset($templateid)) {
			return "Error: Letter Template not specified";
		} else {
			$data['templateid'] = $templateId;
		}

		if ($status == 1) {
			$data['date_sent'] = date('Y-m-d H:i:s');
		}

		if (isset($patientId)) {
			$data['patientid'] = $patientId;
		}

		if (isset($infoId)) {
			$data['info_id'] = $infoId;
		}

		if (isset($parentId) && $status != 1) {
			$data['parentid'] = $parentId;
		} elseif ($status == 1) {
			$data['parentid'] = '';
		}

		if (isset($toPatient)) {
			$data['topatient'] = $toPatient;

			if (!isset($ccToPatient)) {
				$data['cc_topatient'] = $toPatient;
			}
		}

		if (isset($ccToPatient)) {
			$data['cc_topatient'] = $ccToPatient;
		}

		if (isset($mdList)) {
			$data['md_list'] = $mdList;

			if (!isset($ccMdList)) {
				$data['cc_md_list'] = $mdList;
			}
		}

		if (isset($ccMdList)) {
			$data['cc_md_list'] = $ccMdList;
		}

		if (isset($mdReferralList)) {
			$data['md_referral_list'] = $mdReferralList;

			if (!isset($ccMdReferralList)) {
				$data['cc_md_referral_list'] = $mdReferralList;
			}
		}

		if (isset($ccMdReferralList)) {
			$data['cc_md_referral_list'] = $ccMdReferralList;
		}

		if (isset($patReferralList)) {
			$data['pat_referral_list'] = $patReferralList;

			if (!isset($ccPatReferralList)) {
				$data['cc_pat_referral_list'] = $patReferralList;
			}
		}

		if (isset($ccPatReferralList)) {
			$data['cc_pat_referral_list'] = $ccPatReferralList;
		}

		if (isset($template)) {
			$template = html_entity_decode(preg_replace('/(&Acirc;|&acirc;|&nbsp;)+/i', '', $template), ENT_COMPAT | ENT_IGNORE, "UTF-8");

			$data['template'] = $template;
		}

		if (isset($sendMethod)) {
			$data['send_method'] = $sendMethod;
		}

		if (isset($status)) {
			$data['status'] = $status;
		}

		if (isset($deleted)) {
			$data['deleted'] 	= $deleted;
			$data['deleted_by'] = Session::get('userid');
			$data['deleted_on'] = date('Y-m-d H:i:s');
		}

		if (isset($templateType)) {
			$data['template_type'] = $templateType;
		}

		if($fontSize){
			$data['font_size'] = $fontSize;
		}

		if($fontFamily){
			$data['font_family'] = $fontFamily;
		}

  		$data['generated_date'] = $genDate;
  		$data['delivered'] 		= $delivered;
  		$data['docid'] 			= Session::get('docid');
  		$data['userid']			= Session::get('userid');

  		$letterId = $this->letter->insertData($data);

  		if (empty($letterId)) {
  			return 'Error inserting Letter to Database';
  		} else {
  			return $letterId;
  		}
	}
}