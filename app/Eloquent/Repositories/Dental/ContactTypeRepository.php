<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ContactType;
use Prettus\Repository\Eloquent\BaseRepository;

class ContactTypeRepository extends BaseRepository
{
    public function model()
    {
        return ContactType::class;
    }

    /**
     * @return mixed
     */
    public function getActiveNonCorporateTypes()
    {
        return $this->model->select('contacttypeid', 'contacttype')
            ->active()
            ->nonCorporate()
            ->orderBy('sortby')
            ->get();
    }

    /**
     * @return mixed
     */
    public function getPhysicianTypes()
    {
        return $this->model->select(\DB::raw('GROUP_CONCAT(contacttypeid) as physician_types'))
            ->physician()
            ->groupBy('physician')
            ->first();
    }

    /**
     * @param array $fields
     * @param array $where
     * @return mixed
     */
    public function getWithFilter(array $fields = [], array $where = [])
    {
        $object = $this->model;

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

    /**
     * @return mixed
     */
    public function getSorted()
    {
        return $this->model->orderBy('sortby')->get();
    }
}
