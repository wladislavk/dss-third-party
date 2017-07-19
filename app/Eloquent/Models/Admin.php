<?php

namespace DentalSleepSolutions\Eloquent\Models;

use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

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
