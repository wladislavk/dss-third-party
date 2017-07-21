<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Task;
use Prettus\Repository\Eloquent\BaseRepository;

class TaskRepository extends BaseRepository
{
    public function model()
    {
        return Task::class;
    }

    /**
     * @param int $responsibleId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll($responsibleId)
    {
        return $this->model->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->get();
    }

    /**
     * @param int $responsibleId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getOverdue($responsibleId)
    {
        return $this->model->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->overdue()
            ->get();
    }

    /**
     * @param int $responsibleId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getToday($responsibleId)
    {
        return $this->model->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->today()
            ->get();
    }

    /**
     * @param int $responsibleId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getTomorrow($responsibleId)
    {
        return $this->model->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->tomorrow()
            ->get();
    }

    /**
     * @param int $responsibleId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getThisWeek($responsibleId)
    {
        return $this->model->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->thisWeek()
            ->get();
    }

    /**
     * @param int $responsibleId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getNextWeek($responsibleId)
    {
        return $this->model->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->nextWeek()
            ->get();
    }

    /**
     * @param int $responsibleId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getLater($responsibleId)
    {
        return $this->model->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->later()
            ->get();
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllForPatient($docId, $patientId)
    {
        return $this->model->forPatient()
            ->where(function($query) use ($docId) {
                $query->where('du.docid', $docId)
                    ->orWhere('du.userid', $docId);
            })
            ->where('dt.patientid', $patientId)
            ->get();
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getOverdueForPatient($docId, $patientId)
    {
        return $this->model->forPatient()
            ->where(function($query) use ($docId) {
                $query->where('du.docid', $docId)
                    ->orWhere('du.userid', $docId);
            })
            ->where('dt.patientid', $patientId)
            ->overdue()
            ->get();
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getTodayForPatient($docId, $patientId)
    {
        return $this->model->forPatient()
            ->where(function($query) use ($docId) {
                $query->where('du.docid', $docId)
                    ->orWhere('du.userid', $docId);
            })
            ->where('dt.patientid', $patientId)
            ->today()
            ->get();
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getTomorrowForPatient($docId, $patientId)
    {
        return $this->model->forPatient()
            ->where(function($query) use ($docId) {
                $query->where('du.docid', $docId)
                    ->orWhere('du.userid', $docId);
            })
            ->where('dt.patientid', $patientId)
            ->tomorrow()
            ->get();
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getFutureForPatient($docId, $patientId)
    {
        return $this->model->forPatient()
            ->where(function($query) use ($docId) {
                $query->where('du.docid', $docId)
                    ->orWhere('du.userid', $docId);
            })
            ->where('dt.patientid', $patientId)
            ->future()
            ->get();
    }
}
