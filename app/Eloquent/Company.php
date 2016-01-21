<?php

namespace DentalSleepSolutions\Eloquent;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Company as Resource;
use DentalSleepSolutions\Contracts\Repositories\Companies as Repository;

class Company extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'ip_address', 'eligible_api_key', 'stripe_secret_key', 'stripe_publishable_key',
        'logo', 'monthly_fee', 'default_view', 'sfax_security_context', 'sfax_app_id',
        'sfax_app_id', 'sfax_app_key', 'sfax_init_vector', 'fax_fee', 'free_tax',
        'company_type', 'phone', 'fax', 'email', 'plan_id', 'sfax_encryption_key',
        'name', 'add1', 'add2', 'city', 'state', 'zip', 'status', 'adddate',
        'use_support', 'exclusive', 'vob_require_test',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
