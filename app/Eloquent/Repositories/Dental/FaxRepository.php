<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Fax;
use Prettus\Repository\Eloquent\BaseRepository;

class FaxRepository extends BaseRepository
{
    public function model()
    {
        return Fax::class;
    }

    /**
     * @param int $docId
     * @return mixed
     */
    public function getAlerts($docId)
    {
        return $this->model->select(\DB::raw('COUNT(id) AS total'))
            ->where('docid', $docId)
            ->whereRaw('COALESCE(viewed, 0) = 0')
            ->where('sfax_status', 2)
            ->first();
    }

    /**
     * @param int $letterId
     * @param array $data
     * @return bool|int
     */
    public function updateByLetterId($letterId, array $data)
    {
        return $this->model->where('letterid', $letterId)
            ->update($data);
    }
}
