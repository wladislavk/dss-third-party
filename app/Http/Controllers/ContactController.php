<?php namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Route;
use Request;
use Session;

use Ds3\Contracts\ContactTypeInterface;
use Ds3\Contracts\ContactInterface;
use Ds3\Contracts\UserInterface;
use Ds3\Contracts\QualifierInterface;
use Ds3\Contracts\LetterInterface;
use Ds3\Contracts\FaxInterface;
use Ds3\Contracts\LetterTemplateInterface;

use Ds3\Libraries\GeneralFunctions;
use Ds3\Libraries\Constants;
use Ds3\Libraries\MDReferralFilter;

class ContactController extends Controller
{
	private $contactType;
	private $contact;
	private $user;
	private $qualifier;
	private $letter;
	private $fax;
	private $letterTemplate;

	private $request;
	private $contactFields;

	private $activePat;
	private $from;
	private $fromId;
	private $inField;
	private $idField;
	private $ctype;
	private $type;
	private $ctypeeq;
	private $delid;

	public function __construct(ContactTypeInterface $contactType,
								ContactInterface $contact,
								UserInterface $user,
								QualifierInterface $qualifier,
								LetterInterface $letter,
								FaxInterface $fax,
								LetterTemplateInterface $letterTemplate)
	{		
		$this->contactType 		= $contactType;
		$this->contact 			= $contact;
		$this->user 			= $user;
		$this->qualifier 		= $qualifier;
		$this->letter 			= $letter;
		$this->fax 				= $fax;
		$this->letterTemplate 	= $letterTemplate;

		$this->request 		= Request::all();
		$this->activePat 	= GeneralFunctions::getRouteParameter('activePat');
		$this->from 		= GeneralFunctions::getRouteParameter('from');
		$this->fromId 		= GeneralFunctions::getRouteParameter('from_id');
		$this->inField 		= GeneralFunctions::getRouteParameter('in_field');
		$this->idField 		= GeneralFunctions::getRouteParameter('id_field');
		$this->ctype 		= GeneralFunctions::getRouteParameter('ctype');
		$this->type 		= GeneralFunctions::getRouteParameter('type');
		$this->ctypeeq		= GeneralFunctions::getRouteParameter('ctypeeq');
		$this->delid 		= GeneralFunctions::getRouteParameter('delid');

		$this->contactFields = array('salutation', 'firstname', 'lastname', 'middlename', 'company', 'add1', 'add2', 'city',
			'state', 'zip', 'phone1', 'phone2', 'fax', 'email', 'national_provider_id', 'qualifier', 'qualifierid',
			'contacttypeid', 'notes', 'status', 'preferredcontact', 'dea_number'
		);
	}

	public function index()
	{
		$contactTypes = $this->contactType->getPhysicians();

		$physicians = array();
		if (count($contactTypes)) foreach ($contactTypes as $contactType) {
			array_push($physicians, $contactType->contacttypeid);
		}

		$physicianTypes = implode(',', $physicians);
		$contact = $this->contact->get(array(
			'contactid' => !empty(Route::input('ed')) ? Route::input('ed') : null
		));

		if (!empty($message)) {
			foreach ($this->contactFields as $contactField) {
				if (isset($this->request[$contactField])) {
					$contactInfo[$contactField] = $this->request[$contactField];
				} else {
					$contactInfo[$contactField] = '';
				}
			}
		} else {
			foreach ($this->contactFields as $contactField) {
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

		if (!empty(Route::input('ed'))) {
			$contact = $this->contact->get(array(
				'contactid' => !empty(Route::input('ed')) ? Route::input('ed') : null
			));
		}

		$contactTypes = $this->contactType->getContactTypes();
		$qualifiers = $this->qualifier->getQualifiers();

		$showBlock = array();

		$contactId = !empty($contact->contactId) ? $contact->contactId : 0;

		if (count($this->getContactSentLetters($contactId)) > 0) {
			$showBlock['sentLetters'] = true;

			if (isset($contactId)) {
				$showBlock['delete'] = true;
			} elseif (count($this->getContactPendingLetters($contactId)) > 0) {
				$showBlock['deleteWarning'] = true;
			} else {
				$showBlock['delete'] = true;
			}
		}

		$showBlock = array_merge($showBlock, !empty(Session::get('showBlock')) ? Session::get('showBlock') : array());

		$data = array(
			'path' 				=> '/' . Request::segment(1) . '/' . Request::segment(2),
			'physicianTypes' 	=> $physicianTypes,
			'ctype'				=> $this->ctype,
			'butText'			=> $butText,
			'heading'			=> !empty($heading) ? $heading : '',
			'contactInfo'		=> $contactInfo,
			'contactTypes'		=> $contactTypes,
			'contact'			=> !empty($contact) ? $contact : null,
			'type'				=> $this->type,
			'ctypeeq'			=> $this->ctypeeq,
			'qualifiers'		=> $qualifiers,
			'activePat'			=> $this->activePat,
			'from'				=> $this->from,
			'fromId'			=> $this->fromId,
			'inField'			=> $this->inField,
			'idField'			=> $this->idField,
			'showBlock'			=> $showBlock,
			'insertContactId'	=> !empty(Session::get('insertContactId')) ? Session::get('insertContactId') : null
		);

		// dd($data);

		return view('manage.add_contact', $data);
	}

	/**

	*/

	public function add()
	{
		$showBlock = array();

		if (!empty($this->request['contactsub']) && $this->request['contactsub'] == 1) {
			if (!empty(Route::input('ed'))) {
				foreach ($this->contactFields as $contactField) {
					$data[$contactField] = $this->request[$contactField];
				}

				$this->contact->updateData(Route::input('ed'), $data);
				$message = 'Edited Successfully';

				return redirect('/manage/contact')->with('message', $message);
			} else {
				foreach ($this->contactFields as $contactField) {
					$data[$contactField] = $this->request[$contactField];
				}

				$data['phone1'] = GeneralFunctions::num($data['phone1']);
				$data['phone2'] = GeneralFunctions::num($data['phone2']);
				$data['fax'] = GeneralFunctions::num($data['fax']);
				$data['docid'] = Session::get('docId');
				$data['ip_address'] = Request::ip();

				$insertContactId = $this->contact->insertData($data);
				$user = $this->user->findUser(Session::get('docId'));

				if (!empty($user->use_letters) && !empty($user->intro_letters)) {
					$contactType = $this->contactType->get($this->request['contacttypeid']);

					if (!empty($contactType->physician) && $contactType->physician == 1) {
						if (Session::get('userType') != Constants::DSS_USER_TYPE_SOFTWARE) {
							$this->createWelcomeLetter('1', $insertContactId, Session::get('docId'));
						}
						$this->createWelcomeLetter('2', $insertContactId, Session::get('docId'));
						$showBlock['createWelcomeLetter'] = true;
					}
				}

				$contactType = $this->contactType->get($this->request['contacttypeid']);

				$name = $this->request['lastname'] . ', ' . $this->request['firstname'] . ' - ' . $contactType->contacttype;
				$npiName = $this->request['firstname'] . ' ' . $this->request['lastname'];
				$npi = $this->request['national_provider_id'];
				$message = 'Added Successfully';
				// change
				if ($this->from == 'add_patient') {
					if (!empty($this->fromId)) {
						if (!empty($this->request['contacttypeid']) && $this->request['contacttypeid'] == 11) {
							$showBlock['updateReferredBy'] = true;
						}
					} elseif (!empty($this->inField) && !empty($this->idField)) {
						if (substr($this->inField, 0, 16) == 'diagnosising_doc') {
							$showBlock['updateContactField'] = array(
								'name' 	=> $npiName,
								'id'	=> $npi
							);
						} else {
							$showBlock['updateContactField'] = array(
								'name'	=> $name,
								'id'	=> $insertContactId
							);
						}
					}

					$showBlock['disablePopupRefClean'] = true;
				} elseif (!empty($this->activePat)) {
					$activePat = $this->activePat;

					return redirect('/manage/add_patient{!! $activePat !!}')
						->with('ed', $activePat)
						->with('preview', 1)
						->with('addtopat', 1);
				} else {
					return redirect('/manage/contact')->with('message', $message);	
				}
			}
		}

		$redirect = redirect('/manage/add_contact');

		$data = array(
			'showBlock' 		=> $showBlock,
			'insertContactId' 	=> $insertContactId
		);

		if (!empty($data)) foreach ($data as $attribute => $value) {
			$redirect = $redirect->with($attribute, $value);
		}

		return $redirect;
	}

	/**

	*/

	public function view()
	{
		$physicians = $this->contactType->getPhysicians();

		$physicianIds = array();
		if (!empty($physicians)) foreach ($physicians as $physician) {
			array_push($physicianIds, $physician['contacttypeid']);
		}

		$physicianTypes = implode(',', $physicianIds);
		$contact = $this->contact->getDocsleep(!empty(Route::input('ed')) ? Route::input('ed') : null);

		if (!empty($contact)) foreach ($this->contactFields as $field) {
			$contactData[$field] = !empty($contact->$field) ? $contact->$field : '';
		} else foreach ($this->contactFields as $field) {
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

	/**

	*/

	public function manage()
	{
		if (!empty($this->delid)) {
			$this->deleteContactLetters($this->delid);

		}

		foreach ($this->request as $name => $value) {
			$data[$name] = $value;
		}

		$data = array_merge($data, array(
			'path' => '/' . Request::segment(1) . '/' . Request::segment(2)
		));

		return view('manage.contact', $data);
	}

	/**



	*/

	private function deleteContactFromPatients($contactId)
	{
		$docs = array('docsleep', 'docpcp', 'docdentist', 'docent', 'docmdother', 'docmdother2', 'docmdother3');
		
	}

	private function deleteContactLetters($contactId)
	{
		$letters = $this->letter->getContactLetters(array($contactId, 'md_list'), array(
			'status' 	=> 0,
			'delivered' => 0
		));

		if (!empty($letters)) foreach ($letters as $letter) {
			$this->deleteLetter($letter->letterid, false, 'md', $contactId);
		}

		$letters = $this->letter->getContactLetters(array($contactId, 'md_referral_list'), array(
			'status' 	=> 0
		));

		if (!empty($letters)) foreach ($letters as $letter) {
			$this->deleteLetter($letter->letterid, false, 'md_referral', $contactId);
		}
	}

	private function deleteLetter($letterId, $parent = null, $type, $recipientId, $template = null)
	{
		$rval = '';
		$letters = $this->letter->get(array(
			'letterid' => $letterId
		));

		$letter = count($letters) ? $letters[0] : null;

		$contacts = $this->getContactInfo((($letter->topatient == '1') ? $letter->patientid : ''), $letter->md_list, $letter->md_referral_list, $letter->pat_referral_list);
		$totalContacts = count(!empty($contacts['patient']) ? $contacts['patient'] : array())
					   + count(!empty($contacts['mds']) ? $contacts['mds'] : array())
					   + count(!empty($contacts['md_referrals']) ? $contacts['md_referrals'] : array())
					   + count(!empty($contacts['pat_referrals']) ? $contacts['pat_referrals'] : array());

		if (!isset($letterId)) {
			return false;
		} elseif ($totalContacts == 1) {
			$data = array(
				'parentid' 		=> null,
				'deleted' 		=> '1',
				'deleted_by' 	=> Session::get('userId'),
				'deleted_on' 	=> date('Y-m-d H:i:s')
			);

			$letterUpdate = $this->letter->updateData(array('letterid' => $letterId), $data);

			$data = array('viewed' => '1');
			$this->fax->updateData(array('letterid' => $letterId), $data);

			$data = array('parentid' => null);
			$this->letter->updateData(array('parentid' => $letterId), $data);

			return $letterUpdate;
		} else {
			$selectLetters = $this->letter->get(array('letterid' => $letterId));

			if (!empty($selectLetters)) foreach ($selectLetters as $selectLetter) {
				$deleted = '1';
				if ($type == 'patient') {
					$topatient = '1';
					$removepatient = '0';
				} elseif ($type == 'md') {
					$mdList = $recipientId;
					$mds = explode(",", $selectLetter->md_list);
					$key = array_search($recipientId, $mds);
					unset($mds[$key]);
					$newMds = implode(",", $mds);
					$ccMds = explode(",", $selectLetter->cc_md_list);
					$ccKey = array_search($recipientid, $ccMds);
					unset($ccMds[$ccKey]);
					$newCcMds = implode(",", $ccMds);
				} elseif ($type == 'md_referral') {
					$mdReferralList = $recipientId;
					$mdReferrals = explode(",", $selectLetter->md_referral_list);
					$key = array_search($recipientId, $mdReferrals);
					unset($mdReferrals[$key]);
					$newMdReferrals = implode(",", $mdReferrals);
					$ccMdReferrals = explode(",", $selectLetter->cc_md_referral_list);
					$ccKey = array_search($recipientId, $ccMdReferrals);
					unset($ccMdReferrals[$ccKey]);
					$newCcMdReferrals = implode(",", $ccMdReferrals);
				} elseif ($type == 'pat_referral') {
					$patReferralList = $recipientId;
					$patReferrals = explode(",", $selectLetter->pat_referral_list);
					$key = array_search($recipientId, $patReferrals);
					unset($patReferrals[$key]);
					$newPatReferrals = implode(",", $patReferrals);
					$ccPatReferrals = explode(",", $selectLetter->cc_pat_referral_list);
					$ccKey = array_search($recipientId, $ccPatReferrals);
					unset($ccPatReferrals[$ccKey]);
					$newCcPatReferrals = implode(",", $ccPatReferrals);
				}

				$letter = $this->createLetter($selectLetter->templateid, $selectLetter->patientid, $selectLetter->info_id,
											  $topatient, $mdList, $mdReferralList, $patReferralList, $letterId, $template,
											  $selectLetter->send_method, '', $deleted, false
											 );
			}

			if (is_numeric($letter)) {
				if ($type == 'patient') {
					$data = array(
						'topatient'		=> $removepatient,
						'cc_topatient'	=> $removepatient
					);

					$updateLetters = $this->letter->updateData(array(
						'letterid' => $letterId
					), $data);
				} elseif ($type == 'md') {
					$data = array(
						'md_list'		=> $newMds,
						'cc_md_list'	=> $newCcMds
					);

					$updateLetters = $this->letter->updateData(array(
						'letterid' => $letterId
					), $data);
				} elseif ($type == 'md_referral') {
					$data = array(
						'md_referral_list'		=> $newMdReferrals,
						'cc_md_referral_list'	=> $newCcMdReferrals
					);

					$updateLetters = $this->letter->updateData(array(
						'letterid' => $letterId
					), $data);
				} elseif ($type == 'pat_referral') {
					$data = array(
						'pat_referral_list'		=> $newPatReferrals,
						'cc_pat_referral_list'	=> $newCcPatReferrals
					);

					$updateLetters = $this->letter->updateData(array(
						'letterid' => $letterId
					), $data);
				}

				if (empty($updateLetters)) {
					return false;
				} else {
					return $letter;
				}
			}
		}
	}

	private function createLetter($templateId, $pid = null, $infoId = null, $topatient = null,
								  $mdList = null, $mdReferralList = null, $patReferralList = null,
								  $parentId = null, $template = null, $sendMethod = null, $status = null,
								  $deleted = null, $checkRecipient = true, $templateType = null,
								  $ccTopatient = null, $ccMdList = null, $ccMdReferralList = null,
								  $ccPatReferralList = null, $fontSize = null, $fontFamily = null)
	{
		if (isset(Session::get('docId'))) {
			$user = $this->user->findUser(Session::get('docId'));

			if ($user->use_letters != '1') {
				return -1;
			}
		}

		if ((!$topatient && !$mdReferralList && !$mdList && !$patReferralList) || ($checkRecipient && !$mdReferralList && !$mdList && ($templateId == 16 || $templateId == 19))) {
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

		if (!isset($templateId)) {
			return "Error: Letter Template not specified";
		} else {
			$data['templateid'] = $templateId;
		}

		if ($status == 1) {
			$data['date_sent'] = date('Y-m-d H:i:s');
		}

		if (isset($pid)) {
			$data['patientid'] = $pid;
		}

		if (isset($infoId)) {
			$data['info_id'] = $infoId;
		}

		if (isset($parentId) && $status != 1) {
			$data['parentid'] = $parentId;
		}

		if ($status == 1) {
			$data['parentid'] = '';
		}

		if (isset($topatient)) {
			$data['topatient'] = $topatient;
			
			if(!isset($ccTopatient)){
				$data['cc_topatient'] = $topatient;
			}
		}

		if(isset($ccTopatient)){
			$data['cc_topatient'] = $ccTopatient;
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
			$data['template'] = html_entity_decode(preg_replace('/(&Acirc;|&acirc;|&nbsp;)+/i', '', $template), ENT_COMPAT | ENT_IGNORE, "UTF-8");
		}

		if (isset($sendMethod)) {
			$data['send_method'] = $sendMethod;
		}

		if (isset($status)) {
			$data['status'] = $status;
		}

		if (isset($deleted)) {
			$data['deleted'] = $deleted;
			$data['deleted_by'] = Session::get('userId');
			$data['deleted_on'] = date('Y-m-d H:i:s');
		}

		if (isset($templateType)) {
			$data['template_type'] = $templateType;
		}

		if ($fontSize) {
			$data['font_size'] = $fontSize;
		}

		if ($fontFamily) {
			$data['font_family'] = $fontFamily;
		}

		$data['generated_date'] = $genDate;
		$data['delivered'] = $delivered;
		$data['docid'] = Session::get('docId');
		$data['userid'] = Session::get('userId');

		$insertLetterId = $this->letter->insertData($data);

		if (empty($insertLetterId)) {
			return 'Error inserting Letter to Database';
		} else {
			return $insertLetterId;
		}
	}

	private function getContactInfo($patientId, $mdList, $mdReferralList, $patReferralList = null, $letterId = 0)
	{
		$contactInfo = array();

		if (isset($patient)) {
			$patients = $this->patient->get(array(
				'patientid' => $patientId
			));

			if (!empty($patients)) foreach ($patients as $patient) {
				$contactInfo['patient'][] = $patient;
			}
		}

		if (!empty($mdList)) {
			$contact = $this->contact->getDocsleep($mdList);
			$contactInfo['mds'][] = $contact;
		}

		if (!empty($mdReferralList)) {
			$contact = $this->contact->getDocsleep($mdReferralList);
			$contactInfo['md_referrals'][] = $contact;
		}

		if (!empty($patReferralList)) {
			$patients = $this->patient->get(array(
				'patientid' => $patReferralList
			));

			if (!empty($patients)) foreach ($patients as $patient) {
				$contact_info['pat_referrals'][] = $patient;
			}
		}

		return $contactInfo;
	}

	private function createWelcomeLetter($templateId, $mdList, $docId)
	{
		$user = $this->user->findUser($docId);

		if (!empty($user->use_letters) && !empty($user->intro_letters)) {
			$genDate = date('Y-m-d H:i:s');
			$status = '0';
			$delivered = '0';
			$deleted = '0';
			$data['templateid'] = $templateId;

			if ($status == 1) {
				$data['date_sent'] = date('Y-m-d H:i:s');
			}

			if (isset($mdList)) {
				$data['md_list'] = $mdList;
				$data['cc_md_list'] = $mdList;
			}

			if (isset($status)) {
				$data['status'] = $status;
			}

			if (isset($deleted)) {
				$data['deleted'] = $deleted;
			}

			$data['generated_date'] = $genDate;
			$data['delivered'] = $delivered;
			$data['docid'] = $docId;
			$data['userid'] = $docId;

			return $this->letter->insertData($data);
		}
	}

	private function getContactSentLetters($contactId)
	{
		$letters = $this->letter->getContactSentLetters(1, $contactId);

		return $letters;
	}

	private function getContactPendingLetters($contactId)
	{
		$letters = $this->letter->getContactSentLetters(0, $contactId);

		return $letters;
	}
}