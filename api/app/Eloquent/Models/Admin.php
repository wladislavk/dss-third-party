<?php

namespace DentalSleepSolutions\Eloquent\Models;

use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

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
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="salt", type="string"),
 *     @SWG\Property(property="recover_hash", type="string"),
 *     @SWG\Property(property="recover_time", type="string"),
 *     @SWG\Property(property="admin_access", type="integer"),
 *     @SWG\Property(property="last_accessed_date", type="string"),
 *     @SWG\Property(property="claim_margin_top", type="integer"),
 *     @SWG\Property(property="claim_margin_left", type="integer"),
 *     @SWG\Property(property="email", type="string"),
 *     @SWG\Property(property="first_name", type="string"),
 *     @SWG\Property(property="last_name", type="string"),
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
 * @property-read \DentalSleepSolutions\Eloquent\Models\AdminCompany $adminCompany
 * @mixin \Eloquent
 */
class Admin extends AbstractAuthenticatableModel
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
    protected $fillable = [
        'adminid',
        'name',
        'username',
        'password',
        'status',
        'adddate',
        'ip_address',
        'salt',
        'recover_time',
        'admin_access',
        'last_accessed_date',
        'claim_margin_top',
        'claim_margin_left',
        'email',
        'first_name',
        'last_name',
    ];

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function adminCompany()
    {
        return $this->hasOne(AdminCompany::class, 'adminid', 'adminid');
    }
}
