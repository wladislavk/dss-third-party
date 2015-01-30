<?php namespace Ds3\Eloquent\Contact;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
	protected $table = 'dental_contact';

	protected $fillable = ['docid', 'salutation', 'lastname', 'firstname'];

	protected $primaryKey = 'contactid';

	public static function get($where)
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

	public static function getInsContact($docId)
	{
		$insContact = Contact::where('status', '=', 1)->whereNull('merge_id')
													  ->where('contacttypeid', '=', 11)
													  ->where('docid', '=', $docId)
													  ->orderBy('company')
													  ->get();

		return $insContact;
	}

	public static function updateData($contactId, $values)
	{
		$contact = Contact::where('contactid', '=', $contactId)->update($values);

		return $contact;
	}

	public static function insertData($data)
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

	public static function getNewContacts($docId)
	{
		$contactType = DB::table('dental_contacttype')->leftJoin('dental_contact', 'dental_contact.contacttypeid', '=', 'dental_contacttype.contacttypeid')
												->where('docid', '=', $docId);

		$newContacts = DB::table('dental_contact')->leftJoin('dental_contacttype', 'dental_contact.contacttypeid', '=', 'dental_contacttype.contacttypeid')
												  ->where('docid', '=', $docId)
												  ->union($contactType)
												  ->toSql();

		return $newContacts;
	}

	public static function getDocsleep($contactId)
	{
		$docsleep = DB::table(DB::raw('dental_contact dc'))->select(DB::raw('dc.lastname, dc.firstname, dc.middlename, dct.contacttype'))
														   ->leftJoin(DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
														   ->where('contactid', '=', $contactId)
														   ->first();

		return $docsleep;
	}
}