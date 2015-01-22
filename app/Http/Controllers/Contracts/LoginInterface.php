<?php namespace Ds3\Contracts;

interface LoginInterface
{
	public function insertData($data);

	public function get($where);
}