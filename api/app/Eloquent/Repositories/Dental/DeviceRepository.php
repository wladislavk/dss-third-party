<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class DeviceRepository extends AbstractRepository
{
    public function model()
    {
        return Device::class;
    }

    /**
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getByStatus()
    {
        return $this->model->select('deviceid', 'device')
            ->where('status', 1)
            ->orderBy('sortby')
            ->get();
    }
}
