<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'dental_task';
    protected $primaryKey = 'id';
    // public $timestamps = false;

    public function scopeNonActive($query)
    {
        return $query->where(function($query){
            $query->where('dental_task.status', '=', '0')
                  ->orWhereNull('dental_task.status');
        });
    }

    public function scopeOverdue($query)
    {
        return $query->where('dental_task.due_date', '<', 'CURDATE()');
    }

    public function scopeToday($query)
    {
        return $query->where('dental_task.due_date', '=', 'CURDATE()');
    }

    public function scopeTomorrow($query)
    {
        return $query->where('dental_task.due_date', '=', 'DATE_ADD(CURDATE(), INTERVAL 1 DAY)');
    }

    public function scopeFuture($query)
    {
        return $query->where('dental_task.due_date', '>', 'DATE_ADD(CURDATE(), INTERVAL 1 DAY)');
    }

    public function scopeThisWeek($query, $thisSunday)
    {
        return $query->whereRaw("dental_task.due_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 2 DAY) AND '" . $thisSunday . "'");
    }

    public function scopeNextWeek($query, $nextMonday, $nextSunday)
    {
        return $query->whereBetween('dental_task.due_date', array($nextMonday, $nextSunday));
    }

    public function scopeLater($query, $nextSunday)
    {
        return $query->where('dental_task.due_date', '>', $nextSunday);
    }
}
