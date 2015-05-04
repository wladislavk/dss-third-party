<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table = 'dental_login';
    protected $primaryKey = 'loginid';
    //public $timestamps = false;
}
