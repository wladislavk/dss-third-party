<?php namespace Ds3\Http\Controllers;

use Illuminate\Http\Request;

use Ds3\User;
use Ds3\Libraries\Password;

class AuthController extends Controller
{
 	public function index()
 	{
 		return view('manage.login');
 	}

	public function login(Request $request)
	{
		$dataUser = $request->all();
		
		$msg = 'Wrong username or password';
		$username = $dataUser['username'];

		$salt = User::getSalt($username);

		if ($salt) {
			$currentPassword = Password::genPassword($dataUser['password'], $salt);

			$user = User::get($username, $currentPassword);

			if (!empty($user)) {
				return 'Success!'; // change to redirect
			} else {
				return view('manage.login', compact('msg', 'username'));
			}
		} else {
			return view('manage.login', compact('msg', 'username'));
		}
	}
}