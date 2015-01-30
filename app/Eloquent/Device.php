<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

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

	public static function getDevice($deviceId)
	{
		try {
			$device = Device::select('device')->where('deviceid', '=', $deviceId)
										  	  ->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $device;
	}
}