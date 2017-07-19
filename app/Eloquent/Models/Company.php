<?php

namespace DentalSleepSolutions\Eloquent\Models;

use DentalSleepSolutions\Eloquent\Models\Dental\UserCompany;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Contracts\Repositories\Repository;
use DB;

class Company extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    const DSS_COMPANY_TYPE_HST = 2;

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
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

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
        return $this->hasMany(UserCompany::class, 'companyid');
    }

    public function getCompanyLogo($userId)
    {
        return $this->from(DB::raw('companies c'))
            ->select(DB::raw('c.logo'))
            ->join(DB::raw('dental_user_company uc'), 'uc.companyid', '=', 'c.id')
            ->where('uc.userid', $userId)
            ->first();
    }

    public function getHomeSleepTestCompanies($docId = 0)
    {
        return $this->select('h.*', DB::raw('uhc.id as uhc_id'))
            ->from(DB::raw('companies h'))
            ->join(DB::raw('dental_user_hst_company uhc'), function($query) use ($docId) {
                $query->on('uhc.companyid', '=', 'h.id')
                    ->where('uhc.userid', '=', $docId);
            })
            ->where('h.company_type', self::DSS_COMPANY_TYPE_HST)
            ->orderBY('name')
            ->get();
    }

    public function getBillingExclusiveCompany($docId = 0)
    {
        return $this->select('c.name', 'c.exclusive')
            ->from(DB::raw('companies c'))
            ->join(DB::raw('dental_users u'), 'c.id', '=', 'u.billing_company_id')
            ->where('u.userid', $docId)
            ->first();
    }
}
