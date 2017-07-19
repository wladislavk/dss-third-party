<?php

namespace DentalSleepSolutions\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\Dental\UserCompany;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

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