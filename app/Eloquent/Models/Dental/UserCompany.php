<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Models\Company;

/**
 * @SWG\Definition(
 *     definition="UserCompany",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="companyid", type="integer"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\UserCompany
 *
 * @property int $id
 * @property int|null $userid
 * @property int|null $companyid
 * @property string|null $adddate
 * @property string|null $ip_address
 * @mixin \Eloquent
 */
class UserCompany extends AbstractModel
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['userid', 'companyid', 'adddate', 'ip_address'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_user_company';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'companyid');
    }
}
