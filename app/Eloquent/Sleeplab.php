<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Sleeplab extends Model
{
	protected $table = 'dental_sleeplab';

	protected $fillable = ['docid', 'salutation', 'lastname', 'firstname'];

	protected $primaryKey = 'sleeplabid';

	public static function get($docId)
	{
		$sleeplabs = Sleeplab::where('status', '=', 1)->where('docid', '=', $docId)
													 ->orderBy('company')
													 ->get();

		return $sleeplabs;
	}
}