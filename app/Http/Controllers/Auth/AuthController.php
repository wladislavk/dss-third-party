<?php namespace Ds3\Http\Controllers\Auth;
use Ds3\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Session;

use Ds3\Eloquent\Auth\User;
use Ds3\Eloquent\Login\Login;
use Ds3\Eloquent\Login\LoginDetail;
use Ds3\Libraries\Password;

class AuthController extends Controller
{
 	public function index()
 	{
 		return view('manage.login');
 	}

	public function login(Request $request)
	{
		if (!empty(Session::get('loginId'))) {
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

					$dataUser->loginid = Login::insert($data);

					$user = new User();

					foreach ($dataUser as $attribute => $value) {
						$user->$attribute = $value;
					}

					Auth::login($user);

					Session::put('loginId', $user->loginid);
					Session::put('companyId', $user->companyid);
					Session::put('docId', $user->docid);
					Session::put('userType', $user->user_type);

					return redirect('/manage/index');
				}
			} else {
				return view('manage.login', compact('msg', 'username'));
			}
		} else {
			return view('manage.login', compact('msg', 'username'));
		}
	}
}