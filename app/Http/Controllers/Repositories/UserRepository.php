<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Ds3\Contracts\UserInterface;
use Ds3\Eloquent\Auth\User;
use Ds3\Libraries\Password;

class UserRepository implements UserInterface
{
	public function attemptAuth($username, $password)
	{
		$userSalt = User::select('salt')
					->where('username', '=', $username)
					->first();
 
		if ($userSalt) {
			$hashPassword = Password::genPassword($password, $userSalt->salt);

			$dataUser = User::leftJoin('dental_user_company', 'dental_user_company.userid', '=', 'dental_users.userid')
					->select('dental_users.*', 'dental_user_company.companyid')
					->where('username', '=', $username)
					->where('password', '=', $hashPassword)
					->whereBetween('status', array(1, 3))
					->first();

			if (!empty($dataUser)) {
				return ['success' => true, 'user' => $dataUser];
			} else {
				return ['success' => false];
			}
		} else {
			return ['success' => false];
		}		

		return $user;
	}

	public function getType($docId)
	{
		try {
			$user = User::where('userid', '=', $docId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $user->user_type;
	}
}