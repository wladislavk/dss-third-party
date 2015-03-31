<?php namespace Ds3\Contracts;

interface DeviceInterface
{
    public function getActiveDevices();
    public function getDevice($deviceId);
}
