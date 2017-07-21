<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Location;
use Prettus\Repository\Eloquent\BaseRepository;

class LocationRepository extends BaseRepository
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
