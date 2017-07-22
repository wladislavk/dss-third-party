<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Notification;
use Prettus\Repository\Eloquent\BaseRepository;

class NotificationRepository extends BaseRepository
{
    public function model()
    {
        return Notification::class;
    }

    /**
     * @param array $fields
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Collection
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
}
