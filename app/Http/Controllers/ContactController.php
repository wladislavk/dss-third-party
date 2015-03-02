<?php namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Route;
use Request;
use Session;

use Ds3\Contracts\ContactTypeInterface;
use Ds3\Contracts\ContactInterface;
use Ds3\Contracts\UserInterface;
use Ds3\Contracts\QualifierInterface;

use Ds3\Libraries\GeneralFunctions;
use Ds3\Libraries\Constants;

class ContactController extends Controller
{
	private $contactType;
	private $contact;
	private $user;
	private $qualifier;

	private $request;

	public function __construct(ContactTypeInterface $contactType,
								ContactInterface $contact,
								UserInterface $user,
								QualifierInterface $qualifier)
	{
		$this->contactType 	= $contactType;
		$this->contact 		= $contact;
		$this->user 		= $user;
		$this->qualifier 	= $qualifier;
		$this->request 		= Request::all();
	}

	public function index()
	{
		$contactTypes = $this->contactType->getPhysicians();

		$physicians = array();
		if (count($contactType)) foreach ($contactTypes as $contactType) {
			array_push($physicians, $contactType->contacttypeid);
		}

		$physicianTypes = implode(',', $physicians);
		$contact = $this->contact->get(array(
			'contactid' => !empty($this->request['ed']) ? $this->request['ed'] : null
		));

		if (!empty($message)) {
			foreach ($contactFields as $contactField) {
				if (isset($this->request[$contactField])) {
					$contactInfo[$contactField] = $this->request[$contactField];
				} else {
					$contactInfo[$contactField] = '';
				}
			}
		} else {
			foreach ($contactFields as $contactField) {
				if (isset($contact->$contactField)) {
					$contactInfo[$contactField] = $contact->$contactField;
				} else {
					$contactInfo[$contactField] = '';
				}
			}

			$contactInfo['name'] = !empty($contact->firstname) ? $contact->firstname : ''
								 . !empty($contact->middlename) ? $contact->middlename : ''
								 . !empty($contact->lastname) ? $contact->lastname : '';
			$butText = 'Add ';
		}

		if (!empty($contact->contactid)) {
			$butText = 'Edit ';
		} else {
			$butText = 'Add ';
		}

		if (!empty(Route::input('search'))) {
			if (strpos(Route::input('search'), ' ')) {
				$firstname = ucfirst(substr(Route::input('search'), 0, strpos(Route::input('search'), ' ')));
				$lastname = ucfirst(substr(Route::input('search'), strpos(Route::input('search'), ' ') + 1));
			} else {
				$firstname = ucfirst(Route::input('search'));
			}
		}

		if (isset($this->request['ed'])) {
			$contact = $this->contact->get(array(
				'contactid' => !empty($this->request['ed']) ? $this->request['ed'] : null
			));
		}

		$contactTypes = $this->contactType->getContactTypes();
		$qualifiers = $this->qualifier->getQualifiers();

		$data = array(
			'path' 				=> '/' . Request::segment(1) . '/' . Request::segment(2),
			'physicianTypes' 	=> $physicianTypes,
			'ctype'				=> $this->request['ctype'],
			'butText'			=> $butText,
			'heading'			=> !empty($heading) ? $heading : '',
			'contactInfo'		=> $contactInfo,
			'contactTypes'		=> $contactTypes,
			'contact'			=> !empty($contact) ? $contact : null,
			'type'				=> !empty($this->request['type']) ? $this->request['type'] : '',
			'ctypeeq'			=> !empty($this->request['ctypeeq']) ? $this->request['ctypeeq'] : '',
			'qualifiers'		=> $qualifiers
		);

		return view('manage.add_contact', $data);
	}

	/**

	*/

	public function add()
	{
		$contactFields = array('salutation', 'firstname', 'lastname', 'middlename', 'company', 'add1', 'add2', 'city',
			'state', 'zip', 'phone1', 'phone2', 'fax', 'email', 'national_provider_id', 'qualifier', 'qualifierid',
			'greeting', 'sincerely', 'contacttypeid', 'notes', 'status', 'preferredcontact', 'dea_number'
		);

		if (!empty($this->request['contactsub']) && $this->request['contactsub'] == 1) {
			if (!empty($this->request['ed'])) {
				foreach ($contactFields as $contactField) {
					$data[$contactField] = $this->request[$contactField];
				}

				$this->contact->updateData($this->request['ed'], $data);
				$message = 'Edited Successfully';

				return redirect('/manage/contact')->with('message', $message);
			} else {
				foreach ($contactFields as $contactField) {
					$data[$contactField] = $this->request[$contactField];
				}

				$data['phone1'] = GeneralFunctions::num($data['phone1']);
				$data['phone2'] = GeneralFunctions::num($data['phone2']);
				$data['fax'] = GeneralFunctions::num($data['fax']);
				$data['docid'] = Session::get('docId');
				$data['ip_address'] = Request::ip();

				$insertId = $this->contact->insertData($data);
				$user = $this->user->findUser(Session::get('docId'));

				if (!empty($user->use_letters) && !empty($user->intro_letters)) {
					$contactType = $this->contactType->get($this->request['contacttypeid']);

					if (!empty($contactType->physician) && $contactType->physician == 1) {
						if (Session::get('userType') != Constants::DSS_USER_TYPE_SOFTWARE) {

							/**

							*/
							create_welcome_letter('1', $insertId, Session::get('docId'));
							/**

							*/

						}
						create_welcome_letter('2', $insertId, Session::get('docId'));
					}
				}

				$contactType = $this->contactType->get($this->request['contacttypeid']);

				$name = $this->request['lastname'] . ', ' . $this->request['firstname'] . ' - ' . $contactType->contacttype;
				$npiName = $this->request['firstname'] . ' ' . $this->request['lastname'];
				$npi = $this->request['national_provider_id'];
				$message = 'Added Successfully';
				// change
				if (Route::input('from') == 'add_patient') {
					if (!empty(Route::input('from_id'))) {
						// code...
					} elseif (!empty(Route::input('in_field')) && !empty(Route::input('id_field'))) {
						// code...
					}
				} elseif (!empty(Route::input('activePat'))) {
					// code...
				} else {
					// code...	
				}
			}
		}

		return view('manage.add_contact')->with();
	}

	public function view()
	{
		$physicians = $this->contactType->getPhysicians();

		$physicianIds = array();
		if (!empty($physicians)) foreach ($physicians as $physician) {
			array_push($physicianIds, $physician['contacttypeid']);
		}

		$physicianTypes = implode(',', $physicianIds);
		$contact = $this->contact->getDocsleep(!empty(Route::input('ed')) ? Route::input('ed') : null);

		$contactFields = array('salutation', 'firstname', 'middlename', 'lastname', 'company', 'contacttype',
			'add1', 'add2', 'city', 'state', 'zip', 'phone1', 'phone2', 'fax', 'email', 'national_provider_id',
			'qualifier', 'qualifierid', 'greeting', 'sincerely', 'contacttypeid', 'notes', 'preferredcontact', 'status'
		);

		if (!empty($contact)) foreach ($contactFields as $field) {
			$contactData[$field] = !empty($contact->$field) ? $contact->$field : '';
		} else foreach ($contactFields as $field) {
			$contactData[$field] = '';
		}

		$contactData['name'] = (!empty($contact->firstname) ? $contact->firstname . ' ' : '')
							 . (!empty($contact->middlename) ? $contact->middlename . ' ' : '')
							 . (!empty($contact->lastname) ? $contact->lastname . ' ' : '');

		$contactData['phone1'] = GeneralFunctions::formatPhone($contactData['phone1']);
		$contactData['phone2'] = GeneralFunctions::formatPhone($contactData['phone2']);
		$contactData['fax'] = GeneralFunctions::formatPhone($contactData['fax']);

		$corporate = false;
		if (!empty($contact->corporate) && $contact->corporate == '1') {
			$corporate = true;
		}

		$data = array(
			'contactData' 	=> $contactData,
			'corporate'		=> $corporate,
			'ed'			=> !empty(Route::input('ed')) ? Route::input('ed') : null
		);

		return view('manage.view_contact', $data);
	}
}