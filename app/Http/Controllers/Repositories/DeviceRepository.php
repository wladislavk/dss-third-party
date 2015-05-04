<?php
namespace Ds3\Repositories;

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
        $device = Device::select('device')
            ->where('deviceid', '=', $deviceId)
            ->first();

        return $device;
    }
}
