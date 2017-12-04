<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class AppointmentSummaryRepository extends AbstractRepository
{
    public function model()
    {
        return AppointmentSummary::class;
    }

    /**
     * @param int $id
     * @param mixed[] $data
     * @return bool|int
     */
    public function updateById($id, array $data)
    {
        return $this->model
            ->where('id', $id)
            ->update($data)
        ;
    }

    /**
     * @param  int $patientId
     * @return Model|null
     */
    public function getLastAppointmentDevice($patientId)
    {
        return $this->model
            ->select('id')
            ->where('appointment_type', AppointmentSummary::VISITED_APPOINTMENT)
            ->where('patientid', $patientId)
            ->where(function (Builder $query) {
                /** @var Builder|QueryBuilder $queryBuilder */
                $queryBuilder = $query;
                $queryBuilder
                    ->where('segmentid', AppointmentSummary::DEVICE_DELIVERY_SEGMENT)
                    ->orWhere('segmentid', AppointmentSummary::IMPRESSIONS_SEGMENT)
                ;
            })
            ->orderBy('date_completed', 'desc')
            ->orderBy('id', 'desc')
            ->first()
        ;
    }
}
