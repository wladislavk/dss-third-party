<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\Task;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;

class TaskRepository extends AbstractRepository
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
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->get();
    }

    /**
     * @param int $responsibleId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getOverdue($responsibleId)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->whereRaw('dt.due_date < CURDATE()')
            ->get();
    }

    /**
     * @param int $responsibleId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getToday($responsibleId)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->whereRaw('dt.due_date = CURDATE()')
            ->get();
    }

    /**
     * @param int $responsibleId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getTomorrow($responsibleId)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->whereRaw('dt.due_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY)')
            ->get();
    }

    /**
     * @param int $responsibleId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getThisWeek($responsibleId)
    {
        if (Carbon::now()->dayOfWeek == Carbon::SUNDAY) {
            $thisSunday = Carbon::now()->toDateString();
        } else {
            $thisSunday = Carbon::parse('next sunday')->toDateString();
        }

        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->whereRaw('dt.due_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 2 DAY) AND ?', [$thisSunday])
            ->get();
    }

    /**
     * @param int $responsibleId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getNextWeek($responsibleId)
    {
        if (Carbon::now()->dayOfWeek == Carbon::SUNDAY) {
            $nextMonday = Carbon::parse('next tuesday')->toDateString();
            $nextSunday = Carbon::parse('next sunday')->toDateString();
        } else {
            $nextMonday = Carbon::parse('next monday')->toDateString();
            $nextSunday = Carbon::parse('next sunday + 1 week')->toDateString();
        }

        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->whereRaw('dt.due_date BETWEEN ? AND ?', [$nextMonday, $nextSunday])
            ->get();
    }

    /**
     * @param int $responsibleId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getLater($responsibleId)
    {
        if (Carbon::now()->dayOfWeek == Carbon::SUNDAY) {
            $nextSunday = Carbon::parse('next sunday')->toDateString();
        } else {
            $nextSunday = Carbon::parse('next sunday + 1 week')->toDateString();
        }

        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->whereRaw('dt.due_date > ? ORDER BY dt.due_date ASC', [$nextSunday])
            ->get();
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllForPatient($docId, $patientId)
    {
        return $this->forPatient()
            ->where(function (Builder $query) use ($docId) {
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
        return $this->forPatient()
            ->where(function (Builder $query) use ($docId) {
                $query->where('du.docid', $docId)
                    ->orWhere('du.userid', $docId);
            })
            ->where('dt.patientid', $patientId)
            ->whereRaw('dt.due_date < CURDATE()')
            ->get();
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getTodayForPatient($docId, $patientId)
    {
        return $this->forPatient()
            ->where(function (Builder $query) use ($docId) {
                $query->where('du.docid', $docId)
                    ->orWhere('du.userid', $docId);
            })
            ->where('dt.patientid', $patientId)
            ->whereRaw('dt.due_date = CURDATE()')
            ->get();
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getTomorrowForPatient($docId, $patientId)
    {
        return $this->forPatient()
            ->where(function (Builder $query) use ($docId) {
                $query->where('du.docid', $docId)
                    ->orWhere('du.userid', $docId);
            })
            ->where('dt.patientid', $patientId)
            ->whereRaw('dt.due_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY)')
            ->get();
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getFutureForPatient($docId, $patientId)
    {
        return $this->forPatient()
            ->where(function (Builder $query) use ($docId) {
                $query->where('du.docid', $docId)
                    ->orWhere('du.userid', $docId);
            })
            ->where('dt.patientid', $patientId)
            ->whereRaw('dt.due_date > DATE_ADD(CURDATE(), INTERVAL 1 DAY)')
            ->get();
    }

    /**
     * @return Builder
     */
    private function forPatient()
    {
        return $this->model
            ->from(\DB::raw('dental_task dt'))
            ->select(\DB::raw('dt.*, du.name, p.firstname, p.lastname'))
            ->join(\DB::raw('dental_users du'), 'dt.responsibleid', '=', 'du.userid')
            ->leftJoin(\DB::raw('dental_patients p'), 'p.patientid', '=', 'dt.patientid')
            ->where(function (Builder $query) {
                $query->where('dt.status', '0')
                    ->orWhereNull('dt.status');
            });
    }
}
