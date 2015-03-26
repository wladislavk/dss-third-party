<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'dental_history';
    protected $fillable = ['history', 'description', 'sortby', 'status'];
    protected $primaryKey = 'historyid';

    public static function get($historyId)
    {
        $history = History::where('historyid', '=', $historyId)
            ->where('status', '=', 1)
            ->first();

        return $history;
    }
}
