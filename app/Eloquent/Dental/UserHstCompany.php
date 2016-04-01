<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\UserHstCompany as Resource;
use DentalSleepSolutions\Contracts\Repositories\UserHstCompanies as Repository;

class UserHstCompany extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['userid', 'companyid', 'adddate', 'ip_address'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_user_hst_company';

    /**
     * The primary key for the model.
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
