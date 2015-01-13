<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class ContactType extends Model
{
	protected $table = 'dental_contacttype';

	protected $fillable = ['contacttype', 'sortby', 'status'];

	protected $primaryKey = 'contacttypeid';

	public static function get($contactTypeId)
	{
		try {
			$contactType = ContactType::where('contacttypeid', '=', $contactTypeId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $contactType;
	}

	public static function getPhysicians()
	{
		$physicians = ContactType::where('physician', '=', 1)->get();

		return $physicians;
	}

	public static function getContactTypes()
	{
		$contactTypes = ContactType::where('status', '=', 1)->where('corporate', '=', 0)
															->orderBy('sortby')
															->get();

		return $contactTypes;
	}
}