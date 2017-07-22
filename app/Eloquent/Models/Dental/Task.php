<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;

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
 *     @SWG\Property(property="due_date", type="string"),
 *     @SWG\Property(property="recurring", type="integer"),
 *     @SWG\Property(property="recurring_unit", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
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
 * @mixin \Eloquent
 */
class Task extends AbstractModel
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

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeForPatient(Builder $query)
    {
        return $query->from(\DB::raw('dental_task dt'))
            ->select(\DB::raw('dt.*, du.name, p.firstname, p.lastname'))
            ->join(\DB::raw('dental_users du'), 'dt.responsibleid', '=', 'du.userid')
            ->leftJoin(\DB::raw('dental_patients p'), 'p.patientid', '=', 'dt.patientid')
            ->where(function($query) {
                $query->where('dt.status', '0')
                    ->orWhereNull('dt.status');
            });
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOverdue(Builder $query)
    {
        return $query->whereRaw('dt.due_date < CURDATE()');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeToday(Builder $query)
    {
        return $query->whereRaw('dt.due_date = CURDATE()');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeTomorrow(Builder $query)
    {
        return $query->whereRaw('dt.due_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY)');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeThisWeek(Builder $query)
    {
        if (Carbon::now()->dayOfWeek == Carbon::SUNDAY) {
            $thisSunday = Carbon::now()->toDateString();
        } else {
            $thisSunday = Carbon::parse('next sunday')->toDateString();
        }

        return $query->whereRaw('dt.due_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 2 DAY) AND ?', [$thisSunday]);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeNextWeek(Builder $query)
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

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeLater(Builder $query)
    {
        if (Carbon::now()->dayOfWeek == Carbon::SUNDAY) {
            $nextSunday = Carbon::parse('next sunday')->toDateString();
        } else {
            $nextSunday = Carbon::parse('next sunday + 1 week')->toDateString();
        }

        return $query->whereRaw('dt.due_date > ? ORDER BY dt.due_date ASC', [$nextSunday]);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeFuture(Builder $query)
    {
        return $query->whereRaw('dt.due_date > DATE_ADD(CURDATE(), INTERVAL 1 DAY)');
    }
}
