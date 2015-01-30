<?php namespace Ds3\Eloquent\Auth;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
	use Authenticatable, CanResetPassword;

	protected $table = 'dental_users';

	protected $hidden = ['password'];

	protected $primaryKey = 'userid';

	private $first_name;
    private $last_name;
}
