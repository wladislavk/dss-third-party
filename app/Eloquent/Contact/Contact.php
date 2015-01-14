<?php namespace Ds3\Eloquent\Contact;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Contact extends Model
{
	protected $table = 'dental_contact';

	protected $fillable = ['docid', 'salutation', 'lastname', 'firstname'];

	protected $primaryKey = 'contactid';

	public static function get($contactId)
	{
		try {
			$contact = Contact::where('contactid', '=', $contactId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $contact;
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

		return $contact->id;
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
}