<?php

namespace DentalSleepSolutions\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\Models\Dental\UserCompany;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="AdminCompany",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="adminid", type="integer"),
 *     @SWG\Property(property="companyid", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="admin", ref="#/definitions/Admin"),
 *     @SWG\Property(property="company", ref="#/definitions/Company"),
 *     @SWG\Property(property="users", type="array", @SWG\Items(ref="#/definitions/UserCompany"))
 * )
 *
 * DentalSleepSolutions\Eloquent\AdminCompany
 *
 * @property int $id
 * @property int|null $adminid
 * @property int|null $companyid
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property-read \DentalSleepSolutions\Eloquent\Models\Admin $admin
 * @property-read \DentalSleepSolutions\Eloquent\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Models\Dental\UserCompany[] $users
 * @mixin \Eloquent
 */
class AdminCompany extends Model
{
    use WithoutUpdatedTimestamp;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_company';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['id', 'adminid', 'companyid', 'adddate', 'ip_address'];

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


    public function admin()
    {
        return $this->hasOne(Admin::class, 'adminid', 'adminid');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'companyid');
    }
}
