<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

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
class ExternalCompanyUser extends AbstractModel
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
