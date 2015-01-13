<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Device extends Model
{
	protected $table = 'dental_device';

	protected $fillable = ['device', 'description', 'sortby', 'status'];

	protected $primaryKey = 'deviceid';

	public static function get()
	{
		$devices = Device::where('status', '=', 1)->orderBy('sortby')
												  ->get();

		return $devices;
	}
}