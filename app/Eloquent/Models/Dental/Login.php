<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

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
 * @mixin \Eloquent
 */
class Login extends AbstractModel
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'docid',
        'userid',
        'login_date',
        'logout_date',
        'ip_address',
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
