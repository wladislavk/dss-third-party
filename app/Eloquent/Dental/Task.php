<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Task as Resource;
use DentalSleepSolutions\Contracts\Repositories\Tasks as Repository;
use DB;
use Carbon\Carbon;

/**
 * @SWG\Definition(
 *     definition="Task",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="task", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="responsibleid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="due", type="string"),
 *     @SWG\Property(property="recurring", type="integer"),
 *     @SWG\Property(property="recurring", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="patientid", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Task
 *
 * @property int $id
 * @property string|null $task
 * @property string|null $description
 * @property int|null $userid
 * @property int|null $responsibleid
 * @property int|null $status
 * @property string|null $due_date
 * @property int|null $recurring
 * @property int|null $recurring_unit
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $patientid
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task forPatient()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task future()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task later()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task nextWeek()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task overdue()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task thisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task today()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task tomorrow()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereRecurring($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereRecurringUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereResponsibleid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereUserid($value)
 * @mixin \Eloquent
 */
/**
 * @SWG\Definition(
 *     definition="Task",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="task", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="responsibleid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="due", type="string"),
 *     @SWG\Property(property="recurring", type="integer"),
 *     @SWG\Property(property="recurring", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="patientid", type="integer")
 * )
 */
/**
 * @SWG\Definition(
 *     definition="Task",
 *     type="object",
 * 
 * )
 */
class Task extends AbstractModel implements Resource, Repository
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

    public function scopeFuture($query)
    {
        return $query->whereRaw('dt.due_date > DATE_ADD(CURDATE(), INTERVAL 1 DAY)');
    }

    public function getAll($responsibleId = 0)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->get();
    }

    public function getOverdue($responsibleId = 0)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->overdue()
            ->get();
    }

    public function getToday($responsibleId = 0)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->today()
            ->get();
    }

    public function getTomorrow($responsibleId = 0)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->tomorrow()
            ->get();
    }

    public function getThisWeek($responsibleId = 0)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->thisWeek()
            ->get();
    }

    public function getNextWeek($responsibleId = 0)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->nextWeek()
            ->get();
    }

    public function getLater($responsibleId = 0)
    {
        return $this->forPatient()
            ->where('dt.responsibleid', $responsibleId)
            ->later()
            ->get();
    }

    public function getAllForPatient($docId = 0, $patientId = 0)
    {
        return $this->forPatient()
            ->where(function($query) use ($docId) {
                $query->where('du.docid', $docId)
                    ->orWhere('du.userid', $docId);
            })
            ->where('dt.patientid', $patientId)
            ->get();
    }

    public function getOverdueForPatient($docId = 0, $patientId = 0)
    {
        return $this->forPatient()
            ->where(function($query) use ($docId) {
                $query->where('du.docid', $docId)
                    ->orWhere('du.userid', $docId);
            })
            ->where('dt.patientid', $patientId)
            ->overdue()
            ->get();
    }

    public function getTodayForPatient($docId = 0, $patientId = 0)
    {
        return $this->forPatient()
            ->where(function($query) use ($docId) {
                $query->where('du.docid', $docId)
                    ->orWhere('du.userid', $docId);
            })
            ->where('dt.patientid', $patientId)
            ->today()
            ->get();
    }

    public function getTomorrowForPatient($docId = 0, $patientId = 0)
    {
        return $this->forPatient()
            ->where(function($query) use ($docId) {
                $query->where('du.docid', $docId)
                    ->orWhere('du.userid', $docId);
            })
            ->where('dt.patientid', $patientId)
            ->tomorrow()
            ->get();
    }

    public function getFutureForPatient($docId = 0, $patientId = 0)
    {
        return $this->forPatient()
            ->where(function($query) use ($docId) {
                $query->where('du.docid', $docId)
                    ->orWhere('du.userid', $docId);
            })
            ->where('dt.patientid', $patientId)
            ->future()
            ->get();
    }
}
