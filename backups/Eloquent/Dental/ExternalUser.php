<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\ExternalUser as Resource;
use DentalSleepSolutions\Contracts\Repositories\ExternalUsers as Repository;

/**
 * @SWG\Definition(
 *     definition="ExternalUser",
 *     type="object",
 *     @SWG\Property(property="company", ref="#/definitions/ExternalCompany"),
 *     @SWG\Property(property="user", ref="#/definitions/User")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\ExternalUser
 *
 * @property-read \DentalSleepSolutions\Eloquent\Dental\ExternalCompany $company
 * @property-read \DentalSleepSolutions\Eloquent\Dental\User $user
 * @mixin \Eloquent
 */
class ExternalUser extends AbstractModel implements Resource, Repository
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
    protected $table = 'dental_external_users';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * RELATIONS
     */
    public function user () {
        return $this->belongsTo(User::class, 'user_id', 'userid');
    }

    public function company () {
        return $this->belongsTo(ExternalCompany::class, 'company_id', 'id');
    }

    public function getWithFilter($fields = [], $where = [])
    {
        $object = $this;

        if (count($fields)) {
            $object = $object->select($fields);
        }

        if (count($where)) {
            foreach ($where as $key => $value) {
                $object = $object->where($key, $value);
            }
        }

        return $object->get();
    }
}
