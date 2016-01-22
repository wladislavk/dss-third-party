<?php

namespace DentalSleepSolutions\Eloquent;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Admin as Resource;
use DentalSleepSolutions\Contracts\Repositories\Admins as Repository;

class Admin extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'status',
        'adddate', 'ip_address', 'recover_hash',
        'admin_access', 'claim_margin_top', 'claim_margin_left',
        'email', 'first_name', 'last_name'
    ];

    /**
     * Defining guarded attributes
     * 
     * @var array
     */
    protected $guarded = ['password', 'salt'];

    /**
     * Mass of nondisplayed attributes
     * 
     * @var array
     */
    protected $hidden = ['password', 'ip_address', 'salt'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['adddate', 'last_accessed_date', 'recover_time'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'adminid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
