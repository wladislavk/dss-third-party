<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Location;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class LocationRepository extends AbstractRepository
{
    public function model()
    {
        return Location::class;
    }

    /**
     * @param int $docId
     * @return Location[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getDoctorLocations($docId)
    {
        return $this->model->where('docid', $docId)->get();
    }
}
