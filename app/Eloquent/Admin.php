<?php

namespace DentalSleepSolutions\Eloquent;

use DentalSleepSolutions\Contracts\Resources\Admin as Resource;
use DentalSleepSolutions\Contracts\Repositories\Admins as Repository;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="Admin",
 *     type="object",
 *     required={"adminid"},
 *     @SWG\Property(property="adminid", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="username", type="string"),
 *     @SWG\Property(property="password", type="string"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="salt", type="string"),
 *     @SWG\Property(property="recover", type="string"),
 *     @SWG\Property(property="recover", type="string"),
 *     @SWG\Property(property="admin", type="integer"),
 *     @SWG\Property(property="last", type="string"),
 *     @SWG\Property(property="claim", type="integer"),
 *     @SWG\Property(property="claim", type="integer"),
 *     @SWG\Property(property="email", type="string"),
 *     @SWG\Property(property="first", type="string"),
 *     @SWG\Property(property="last", type="string"),
 *     @SWG\Property(property="adminCompany", ref="#/definitions/AdminCompany")
 * )
 *
 * DentalSleepSolutions\Eloquent\Admin
 *
 * @property int $adminid
 * @property string|null $name
 * @property string|null $username
 * @property string|null $password
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $salt
 * @property string|null $recover_hash
 * @property string|null $recover_time
 * @property int|null $admin_access
 * @property string|null $last_accessed_date
 * @property int|null $claim_margin_top
 * @property int|null $claim_margin_left
 * @property string|null $email
 * @property string|null $first_name
 * @property string|null $last_name
 * @property-read \DentalSleepSolutions\Eloquent\AdminCompany $adminCompany
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereAdminAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereAdminid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereClaimMarginLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereClaimMarginTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereLastAccessedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereRecoverHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereRecoverTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereSalt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Admin whereUsername($value)
 * @mixin \Eloquent
 */
/**
 * @SWG\Definition(
 *     definition="Admin",
 *     type="object",
 *     required={"adminid"},
 *     @SWG\Property(property="adminid", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="username", type="string"),
 *     @SWG\Property(property="password", type="string"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="salt", type="string"),
 *     @SWG\Property(property="recover", type="string"),
 *     @SWG\Property(property="recover", type="string"),
 *     @SWG\Property(property="admin", type="integer"),
 *     @SWG\Property(property="last", type="string"),
 *     @SWG\Property(property="claim", type="integer"),
 *     @SWG\Property(property="claim", type="integer"),
 *     @SWG\Property(property="email", type="string"),
 *     @SWG\Property(property="first", type="string"),
 *     @SWG\Property(property="last", type="string"),
 *     @SWG\Property(property="adminCompany", ref="#/definitions/AdminCompany")
 * )
 */
/**
 * @SWG\Definition(
 *     definition="Admin",
 *     type="object",
 * 
 * )
 */
class Admin extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['adminid', 'name', 'username', 'password', 'status', 'adddate', 'ip_address', 'salt',
        'recover_time', 'admin_access', 'last_accessed_date', 'claim_margin_top', 'claim_margin_left', 'email',
        'first_name', 'last_name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'ip_address', 'salt'];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';


    protected $primaryKey = 'adminid';


    /**
     * User has many Location
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adminCompany()
    {
        return $this->hasOne(AdminCompany::class, 'adminid', 'adminid');
    }
}
