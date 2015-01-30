<?php namespace Ds3\Auth;

interface AuthenticateInterface
{
	public function getByUsername($username,$model);

	public function recoverAndSetHash($id,$email,$model,$columnName);

	public function getUserSalt($username,$model);

	public function generatePassword($password,$salt);

	public function attempt($username,$password,$model);
	
}