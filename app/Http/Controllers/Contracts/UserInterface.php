<?php namespace Ds3\Contracts;

interface UserInterface
{
	public function attemptAuth($username, $hashPassword);
	
	public function getType($docId);
}