<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="LoginDetail",
 *     type="object",
 *     required={"l_detailid"},
 *     @SWG\Property(property="l_detailid", type="integer"),
 *     @SWG\Property(property="loginid", type="integer"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="cur_page", type="string"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\LoginDetail
 *
 * @property int $l_detailid
 * @property int|null $loginid
 * @property int|null $userid
 * @property string|null $cur_page
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @mixin \Eloquent
 */
class LoginDetail extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'loginid',
        'userid',
        'cur_page',
        'adddate',
        'ip_address',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_login_detail';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'l_detailid';

    const CREATED_AT = 'adddate';
}
