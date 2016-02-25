<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\Login as Resource;
use DentalSleepSolutions\Contracts\Repositories\Logins as Repository;

class Login extends Model implements Resource, Repository
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['docid', 'userid', 'login_date', 'logout_date'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_login';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'loginid';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
