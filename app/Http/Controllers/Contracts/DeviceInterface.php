<?php namespace Ds3\Contracts;

interface DeviceInterface
{
	public function get();

	public function getDevice($deviceId);
}