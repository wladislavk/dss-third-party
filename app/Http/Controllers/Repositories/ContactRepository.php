<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\ContactInterface;
use Ds3\Eloquent\Contact\Contact;

class ContactRepository implements ContactInterface
{
	public function get($where)
	{
		$contact = new Contact();

		foreach ($where as $attribute => $value) {
			$contact = $contact->where($attribute, '=', $value);
		}

		try {
			$contact = $contact->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $contact;
	}

	public function getInsContact($docId)
	{
		$insContact = Contact::where('status', '=', 1)
					->whereNull('merge_id')
					->where('contacttypeid', '=', 11)
					->where('docid', '=', $docId)
					->orderBy('company')
					->get();

		return $insContact;
	}

	public function updateData($contactId, $values)
	{
		$contact = Contact::where('contactid', '=', $contactId)->update($values);

		return $contact;
	}

	public function insertData($data)
	{
		$contact = new Contact();

		foreach ($data as $attribute => $value) {
			$contact->$attribute = $value;
		}

		try {
			$contact->save();
		} catch (QueryException $e) {
			return null;
		}

		return $contact->contactid;
	}

	public function getNewContacts($docId)
	{
		$contactType = DB::table('dental_contacttype')
					->leftJoin('dental_contact', 'dental_contact.contacttypeid', '=', 'dental_contacttype.contacttypeid')
					->where('docid', '=', $docId);

		$newContacts = Contact::leftJoin('dental_contacttype', 'dental_contact.contacttypeid', '=', 'dental_contacttype.contacttypeid')
					->where('docid', '=', $docId)
					->union($contactType)
					->toSql();

		return $newContacts;
	}

	public function getDocsleep($contactId)
	{
		$docsleep = DB::table(DB::raw('dental_contact dc'))
				->leftJoin(DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
				->where('contactid', '=', $contactId)
				->first();

		return $docsleep;
	}

	public function getPatientContacts($patientId)
	{
		$contacts = Contact::select('contactid')
				->join('dental_patients', 'dental_patients.referred_by', '=', 'dental_contact.contactid')
				->join(DB::raw('dental_contacttype ct'), 'ct.contacttypeid', '=', 'dental_contact.contacttypeid')
				->where('dental_patients.patientid', '=', $patientId)
				->where('ct.physician', '!=', 1)
				->get();

		return $contacts;
	}
}