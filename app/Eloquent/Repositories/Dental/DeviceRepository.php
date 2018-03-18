<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Support\Collection;

class DeviceRepository extends AbstractRepository
{
    public function model()
    {
        return Device::class;
    }

    /**
     * @return Device[]|Collection
     */
    public function getByStatus(): iterable
    {
        return $this->model
            ->where('status', 1)
            ->orderBy('sortby')
            ->get()
        ;
    }
}
