<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\ExternalCompanyUser as Resource;
use DentalSleepSolutions\Contracts\Repositories\ExternalCompanyUsers as Repository;

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
