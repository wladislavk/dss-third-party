<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Task as Resource;
use DentalSleepSolutions\Contracts\Repositories\Tasks as Repository;
use DB;
use Carbon\Carbon;

class Task extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_task';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function scopeForPatient($query)
    {
        return $query->from(DB::raw('dental_task dt'))
            ->select(DB::raw('dt.*, du.name, p.firstname, p.lastname'))
            ->join(DB::raw('dental_users du'), 'dt.responsibleid', '=', 'du.userid')
            ->leftJoin(DB::raw('dental_patients p'), 'p.patientid', '=', 'dt.patientid')
            ->where(function($query) {
                $query->where('dt.status', '0')
                    ->orWhereNull('dt.status');
            });
    }

    public function scopeOverdue($query)
    {
        return $query->whereRaw('dt.due_date < CURDATE()');
    }

    public function scopeToday($query)
    {
        return $query->whereRaw('dt.due_date = CURDATE()');
    }

    public function scopeTomorrow($query)
    {
        return $query->whereRaw('dt.due_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY)');
    }

    public function scopeThisWeek($query)
    {
        if (Carbon::now()->dayOfWeek == Carbon::SUNDAY) {
            $thisSunday = Carbon::now()->toDateString();
        } else {
            $thisSunday = Carbon::parse('next sunday')->toDateString();
        }

        return $query->whereRaw('dt.due_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 2 DAY) AND ?', [$thisSunday]);
    }

    public function scopeNextWeek($query)
    {
        if (Carbon::now()->dayOfWeek == Carbon::SUNDAY) {
            $nextMonday = Carbon::parse('next tuesday')->toDateString();
            $nextSunday = Carbon::parse('next sunday')->toDateString();
        } else {
            $nextMonday = Carbon::parse('next monday')->toDateString();
            $nextSunday = Carbon::parse('next sunday + 1 week')->toDateString();
        }

        return $query->whereRaw('dt.due_date BETWEEN ? AND ?', [$nextMonday, $nextSunday]);
    }

    public function scopeLater($query)
    {
        if (Carbon::now()->dayOfWeek == Carbon::SUNDAY) {
            $nextSunday = Carbon::parse('next sunday')->toDateString();
        } else {
            $nextSunday = Carbon::parse('next sunday + 1 week')->toDateString();
        }

        return $query->whereRaw('dt.due_date > ? ORDER BY dt.due_date ASC', [$nextSunday]);
    }

    public function getAll($responsibleId)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->get();
    }

    public function getOverdue($responsibleId)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->overdue()
            ->get();
    }

    public function getToday($responsibleId)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->today()
            ->get();
    }

    public function getTomorrow($responsibleId)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->tomorrow()
            ->get();
    }

    public function getThisWeek($responsibleId)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->thisWeek()
            ->get();
    }

    public function getNextWeek($responsibleId)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->nextWeek()
            ->get();
    }

    public function getLater($responsibleId)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->later()
            ->get();
    }
}
