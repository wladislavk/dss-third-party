<?php

namespace DentalSleepSolutions\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

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
     * @var bool
     */
    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Company has many related users.
     *
     * @dynamicProperty Might be used as property $this->users then
     * returns \Illuminate\Database\Eloquent\Collection
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(DentalUserCompany::class, 'companyid');
    }
}
