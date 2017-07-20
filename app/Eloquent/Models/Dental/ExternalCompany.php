<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\Resource;

/**
 * @SWG\Definition(
 *     definition="ExternalCompany",
 *     type="object",
 *     @SWG\Property(property="users", type="array", @SWG\Items(ref="#/definitions/User"))
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\ExternalCompany
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Models\Dental\User[] $users
 * @mixin \Eloquent
 */
class ExternalCompany extends AbstractModel implements Resource
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
    protected $table = 'dental_external_companies';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * RELATIONS
     */
    public function users () {
        return $this->hasManyThrough(User::class, ExternalCompanyUser::class, 'user_id', 'userid');
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
