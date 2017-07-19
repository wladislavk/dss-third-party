<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\ExternalCompanyUser as Resource;
use DentalSleepSolutions\Contracts\Repositories\ExternalCompanyUsers as Repository;

/**
 * @SWG\Definition(
 *     definition="ExternalCompanyUser",
 *     type="object",
 * 
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\ExternalCompanyUser
 *
 * @mixin \Eloquent
 */
class ExternalCompanyUser extends AbstractModel implements Resource, Repository
{
    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_external_company_user';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public function getWithFilter($fields = [], $where = [])
    {
        // TODO: Implement getWithFilter() method.
    }
}
