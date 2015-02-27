<?php namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Route;

use Ds3\Contracts\ContactTypeInterface;
use Ds3\Contracts\ContactInterface;

use Ds3\Libraries\GeneralFunctions;

class ContactController extends Controller
{
	private $contactType;
	private $contact;

	public function __construct(ContactTypeInterface $contactType,
								ContactInterface $contact)
	{
		$this->contactType 	= $contactType;
		$this->contact 		= $contact;
	}

	public function index()
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