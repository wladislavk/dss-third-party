<?php namespace Ds3\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Ds3\User;
use Ds3\Login;
use Ds3\LoginDetail;
use Ds3\Libraries\Password;

class AuthController extends Controller
{
 	public function index()
 	{
 		return view('manage.login');
 	}

	public function login(Request $request)
	{
		if (!empty(Auth::user()->loginid)) {
			$data = array(
				'loginid' 		=> Auth::user()->loginid,
				'userid' 		=> Auth::user()->userid,
				'cur_page' 		=> $request->route()->uri(),
				'ip_address' 	=> $request->ip()
			);

			LoginDetail::insert($data);
		}

		$requestUser = $request->all();
		
		$msg = 'Wrong username or password';
		$username = $requestUser['username'];

		$salt = User::getSalt($username);

		if ($salt) {
			$hashPassword = Password::genPassword($requestUser['password'], $salt);
			$dataUser = User::get($username, $hashPassword);

			if (!empty($dataUser)) {
				if ($dataUser->status == '3') {
					$msg = 'This account has been suspended.';

					return view('manage.login', compact('msg', 'username'));
				} else {
					if ($dataUser->docid != 0) {
						$dataUser->user_type = User::getType($dataUser->docid);					 
					} else {
						$dataUser->docid = $dataUser->userid;
					}

					$data = array(
						'docid' 		=> $dataUser->docid,
						'userid' 		=> $dataUser->userid,
						'login_date' 	=> date("Y-m-d H:i:s"),
						'ip_address' 	=> $request->ip()
					);

					$dataUser->loginid = Login::getId($data);

					$user = new User();

					foreach ($dataUser as $attribute => $value) {
						$user->$attribute = $value;
					}

					Auth::login($user);

					// dd(Auth::user());

					return 'Success!'; // change to redirect
				}
			} else {
				return view('manage.login', compact('msg', 'username'));
			}
		} else {
			return view('manage.login', compact('msg', 'username'));
		}
	}
}