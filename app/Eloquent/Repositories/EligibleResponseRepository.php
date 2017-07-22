<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\EligibleResponse;
use Prettus\Repository\Eloquent\BaseRepository;

class EligibleResponseRepository extends BaseRepository
{
    public function model()
    {
        return EligibleResponse::class;
    }

    /**
     * Get latest record for reference_id / event_type pair.
     *
     * @param string $reference_id
     * @param string|array $event_type
     * @return EligibleResponse|null
     */
    public function getWhere($reference_id, $event_type)
    {
        $query = $this->model->where('reference_id', $reference_id)->orderBy('adddate', 'DESC');

        if (is_array($event_type)) {
            return $query->whereIn('event_type', $event_type)->first();
        }

        return $query->where('event_type', $event_type)->first();
    }
}
