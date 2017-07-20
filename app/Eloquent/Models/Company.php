<?php

namespace DentalSleepSolutions\Eloquent\Models;

use DentalSleepSolutions\Eloquent\Models\Dental\UserCompany;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DB;

/**
 * @SWG\Definition(
 *     definition="Company",
 *     type="object",
 *     required={"id", "status"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="add1", type="string"),
 *     @SWG\Property(property="add2", type="string"),
 *     @SWG\Property(property="city", type="string"),
 *     @SWG\Property(property="state", type="string"),
 *     @SWG\Property(property="zip", type="string"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="eligible_api_key", type="string"),
 *     @SWG\Property(property="stripe_secret_key", type="string"),
 *     @SWG\Property(property="stripe_publishable_key", type="string"),
 *     @SWG\Property(property="logo", type="string"),
 *     @SWG\Property(property="monthly_fee", type="float"),
 *     @SWG\Property(property="default_new", type="integer"),
 *     @SWG\Property(property="sfax_security_context", type="string"),
 *     @SWG\Property(property="sfax_app_id", type="string"),
 *     @SWG\Property(property="sfax_app_key", type="string"),
 *     @SWG\Property(property="sfax_init_vector", type="string"),
 *     @SWG\Property(property="fax_fee", type="float"),
 *     @SWG\Property(property="free_fax", type="integer"),
 *     @SWG\Property(property="company_type", type="integer"),
 *     @SWG\Property(property="phone", type="string"),
 *     @SWG\Property(property="fax", type="string"),
 *     @SWG\Property(property="email", type="string"),
 *     @SWG\Property(property="plan_id", type="integer"),
 *     @SWG\Property(property="sfax_encryption_key", type="string"),
 *     @SWG\Property(property="use_support", type="integer"),
 *     @SWG\Property(property="exclusive", type="integer"),
 *     @SWG\Property(property="vob_require_test", type="integer"),
 *     @SWG\Property(property="users", type="array", @SWG\Items(ref="#/definitions/UserCompany"))
 * )
 *
 * DentalSleepSolutions\Eloquent\Company
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $add1
 * @property string|null $add2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property int $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $eligible_api_key
 * @property string|null $stripe_secret_key
 * @property string|null $stripe_publishable_key
 * @property string|null $logo
 * @property float|null $monthly_fee
 * @property int|null $default_new
 * @property string|null $sfax_security_context
 * @property string|null $sfax_app_id
 * @property string|null $sfax_app_key
 * @property string|null $sfax_init_vector
 * @property float|null $fax_fee
 * @property int|null $free_fax
 * @property int|null $company_type
 * @property string|null $phone
 * @property string|null $fax
 * @property string|null $email
 * @property int|null $plan_id
 * @property string|null $sfax_encryption_key
 * @property int|null $use_support
 * @property int|null $exclusive
 * @property int|null $vob_require_test
 * @property-read \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Models\Dental\UserCompany[] $users
 * @mixin \Eloquent
 */
class Company extends AbstractModel
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
