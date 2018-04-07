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
     * @param int $patientId
     * @return AppointmentSummary[]|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getByPatient($patientId)
    {
        return $this->model
            ->select('*')
            ->where('patientid', $patientId)
            ->where('date_completed', '!=', '')
            ->whereNotNull('date_completed')
            ->orderBy('date_completed', 'desc')
            ->orderBy('id', 'desc')
            ->get()
        ;
    }

    /**
     * @param  int $patientId
     * @return array
     */
    public function getLastAppointmentDevice($patientId)
    {
        $result = $this->model
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
        ;
        $arrayResult = $result->first()->toArray();
        return $arrayResult;
    }

    /**
     * @param int $patientId
     * @return array|null
     */
    public function getLastTrackerStep(int $patientId): ?array
    {
        $result = $this->model
            ->select('*')
            ->from(\DB::raw('dental_flow_pg2_info info'))
            ->join(\DB::raw('dental_flowsheet_steps steps'), 'info.segmentid', '=', 'steps.id')
            ->where('info.date_completed', '!=', '')
            ->whereNotNull('info.date_completed')
            ->where('info.patientid', $patientId)
            ->orderBy('info.date_completed', 'desc')
            ->orderBy('info.id', 'desc')
            ->get()
        ;
        if ($result) {
            return $result->toArray();
        }
        return null;
    }

    /**
     * @param int $patientId
     * @return AppointmentSummary|null
     */
    public function getFutureAppointment(int $patientId): ?AppointmentSummary
    {
        /** @var AppointmentSummary|null $result */
        $result = $this->model
            ->where('appointment_type', 0)
            ->where('patientid', $patientId)
            ->first()
        ;
        return $result;
    }

    /**
     * @param int $patientId
     * @return AppointmentSummary|null
     */
    public function getDeviceDelivery(int $patientId): ?AppointmentSummary
    {
        $deviceSegments = [4, 7];
        /** @var AppointmentSummary|null $result */
        $result = $this->model
            ->where('patientid', $patientId)
            ->where('appointment_type', 1)
            ->whereIn('segmentid', $deviceSegments)
            ->orderBy('date_completed', 'desc')
            ->orderBy('id', 'desc')
            ->first()
        ;
        return $result;
    }

    /**
     * @param int $stepId
     * @param int $patientId
     * @return int
     */
    public function getCompletedByPatient(int $stepId, int $patientId): int
    {
        $query = $this->model
            ->where('segmentid', $stepId)
            ->where('patientid', $patientId)
            ->where('date_completed', '!=', '0000-00-00');
        ;
        $result = $query->get();
        return sizeof($result->toArray());
    }
}
