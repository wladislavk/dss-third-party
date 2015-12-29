<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'dental_users';
    protected $primaryKey = 'userid';
}
