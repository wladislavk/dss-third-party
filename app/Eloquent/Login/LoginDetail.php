<?php namespace Ds3\Eloquent\Login;

use Illuminate\Database\Eloquent\Model;

class LoginDetail extends Model
{
    protected $table = 'dental_login_detail';
    protected $primaryKey = 'l_detailid';

    public $timestamps = false;
}
