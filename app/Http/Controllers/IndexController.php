<?php namespace Ds3\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Session;

use Ds3\Hst;
use Ds3\Fax;
use Ds3\User;
use Ds3\Task;
use Ds3\Note;
use Ds3\Memo;
use Ds3\QPage3;
use Ds3\Ledger;
use Ds3\Letter;
use Ds3\Company;
use Ds3\FlowPg2;
use Ds3\Patient;
use Ds3\Insurance;
use Ds3\MemoAdmin;
use Ds3\SupportTicket;
use Ds3\PatientContact;
use Ds3\PatientInsurance;
use Ds3\InsurancePreauth;
use Ds3\DocumentCategory;

class IndexController extends Controller
{
	public function index()
	{
		/*
 		$receivedValues = User::getValues(Session::get('docId'), array('homepage', 'manage_staff', 'use_course', 'use_eligible_api'));
 		$course = User::getCourse(Auth::user()->userid);
 		$documentCategories = DocumentCategory::get();
 		$tasks = Task::get(Auth::user()->userid, 'lat', array('next_sun' => date('Y-m-d',  strtotime("next Sunday + 1 week"))));	
 		$course = User::getCourse(Auth::user()->userid);
 		$memoAdmins = MemoAdmin::get();
 		$generatedDates = Letter::getUnmailedLetters(Session::get('docId'));
		$pendingNodssClaims = Insurance::getPendingNodssClaims(Session::get('docId'), array(0, 1, 1, 1));
		$unmailedClaims = Insurance::getUnmailedClaims(Session::get('docId'), 0, 1);
		InsurancePreauth::get(Session::get('docId'), 0);
		InsurancePreauth::getPendingPreauth(Session::get('docId'), 1)

		/* Eloquent ORM
		*
		* PatientContact::find(1)->patient()->where('docid', '=', 1);
		*
		*/

		/*
		Patient::getPendingDuplicates(Session::get('docId'))
		Patient::getBounce(Session::get('docId'))
		Note::getUnsigned(Session::get('docId'))
		InsurancePreauth::getRejectedPreauth(Session::get('docId'), 1)
		Fax::getFaxAlerts(Session::get('docId'))
		SupportTicket::getSupport(Session::get('docId'), 1)
		Patient::getJoinPatient(Session::get('docId'))
		FlowPg2::getStep(16)
		QPage3::getValues(16, array('other_allergens', 'allergenscheck'))
		User::getCourseJoin(1)
		Company::getLogo(20)
		Task::get(1, 0, 16, 'task')
		Patient::get(array('parent_patientid' => 1))
		PatientContact::get(0, array('dental_patients.docid' => 0, 'dental_patients.patientid' => 16))
		PatientInsurance::get(0, ['dental_patients.docid' => 1, 'dental_patients.patientid' => 16])
		Insurance::get(Session::get('docId'), array(0, 1, 1, 1), array('patientid' => 16))
		Hst::get(0, '1,1,0,1', array('patient_id' => 16))
		User::getUseLetters(Session::get('docId'))
		Letter::getGeneratedDates(array('dental_letters.status' => 0, 'dental_letters.deleted' => 0, 'dental_letters.docid' => 0))
		Ledger::getPendingClaims(0, array('dental_ledger.status' => 0, 'dental_ledger.docid' => 0, 'dental_transaction_code.docid' => 0, 'dental_patients.p_m_dss_file' => 2, 'dental_transaction_code.type' => 1))
		Memo::get(1)
		*/	

 		dd();

 		/*
 		|------------------------------------------------------------
 		| For Insurance.php (method - get)
 		| Hst.php (method - get)
 		|------------------------------------------------------------

		$status = '';
		foreach ($input as $value) {
			$status .= $value . ',';
		}
		$status = substr($status, 0, strlen($status) - 1);

		|------------------------------------------------------------
		*/
 	}
}