<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Epworth extends Model
{
    protected $table = 'dental_epworth';
    protected $fillable = ['epworth', 'description', 'sortby', 'status'];
    protected $primaryKey = 'epworthid';

    public static function get()
    {
        $epworth = Epworth::where('status', '=', 1)
            ->orderBy('sortby')
            ->get();

        return $epworth;
    }

    public static function getJoin($followupId)
    {
        $epworth = DB::table(DB::raw('dental_epworth e'))
            ->select(DB::raw('e.*, fu.answer'))
            ->leftJoin(DB::raw('dentalsummfu_ess fu'), function($join) use ($followupId){
                $join->on('fu.epworthid', '=', 'e.epworthid')
                     ->where('fu.followupid', '=', $followupId);
            })
            ->where('e.status', '=', 1)
            ->orderBy('e.sortby')
            ->get();

        return $epworth;
    }
}
