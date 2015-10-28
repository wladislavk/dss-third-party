<?php
namespace DentalSleepSolutions;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'name', 'add1', 'add2',
        'city', 'state', 'zip',
        'status', 'adddate', 'ip_address',
        'eligible_api_key', 'stripe_secret_key', 'stripe_publishable_key',
        'sfax_security_context', 'sfax_app_key', 'sfax_encryption_key',
        'logo', 'monthly_fee', 'default_view',
        'sfax_app_id', 'sfax_app_id', 'sfax_init_vector',
        'fax_fee', 'free_tax', 'company_type',
        'phone', 'fax', 'email',
        'plan_id', 'use_support', 'exclusive',
        'vob_require_test'
    ];

    /**
     * Defining guarded attributes
     * 
     * @var array
     */
    protected $guarded = [];

    /**
     * Mass of nondisplayed attributes
     * 
     * @var array
     */
    protected $hidden = [
        'ip_address', 'eligible_api_key', 'stripe_secret_key',
        'stripe_publishable_key', 'sfax_security_context', 'sfax_app_key',
        'sfax_encryption_key'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public function Users()
    {
        $this->hasMany('DentalSleepSolutions\DentalUserCompany', 'companyid', 'id');
    }

    //SELECT eligible_api_key FROM dental_user_company LEFT JOIN companies ON dental_user_company.companyid = companies.id WHERE dental_user_company.userid =

}
