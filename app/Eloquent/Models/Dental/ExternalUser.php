<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\ExternalUser as Resource;
use DentalSleepSolutions\Contracts\Repositories\ExternalUsers as Repository;

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
