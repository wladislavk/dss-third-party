<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\Login as Resource;
use DentalSleepSolutions\Contracts\Repositories\Logins as Repository;

/**
 * @SWG\Definition(
 *     definition="Login",
 *     type="object",
 *     required={"loginid"},
 *     @SWG\Property(property="loginid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="login_date", type="string"),
 *     @SWG\Property(property="logout_date", type="string"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Login
 *
 * @property int $loginid
 * @property int|null $docid
 * @property int|null $userid
 * @property string|null $login_date
 * @property string|null $logout_date
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Login whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Login whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Login whereLoginDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Login whereLoginid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Login whereLogoutDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Login whereUserid($value)
 * @mixin \Eloquent
 */
class Login extends AbstractModel implements Resource, Repository
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'docid', 'userid', 'login_date',
        'logout_date', 'ip_address'
    ];

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
