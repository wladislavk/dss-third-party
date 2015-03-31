<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\DeviceInterface;
use Ds3\Eloquent\Device;

class DeviceRepository implements DeviceInterface
{
    public function getActiveDevices()
    {
        $devices = Device::active()
            ->orderBy('sortby')
            ->get();

        return $devices;
    }

    public function getDevice($deviceId)
    {
        try {
            $device = Device::select('device')
                ->where('deviceid', '=', $deviceId)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return $device;
    }
}
