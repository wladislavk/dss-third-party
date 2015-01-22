<?php namespace Ds3\Eloquent\Login;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Login extends Model
{
	protected $table = 'dental_login';

	protected $primaryKey = 'loginid';

	// public $timestamps = false;
}