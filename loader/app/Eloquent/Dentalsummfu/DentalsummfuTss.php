<?php
namespace Ds3\Eloquent\Dentalsummfu;

use Illuminate\Database\Eloquent\Model;

class DentalsummfuTss extends Model
{
    protected $table = 'dentalsummfu_tss';
    protected $fillable = ['followupid', 'thorntonid', 'answer'];
    protected $primaryKey = 'id';

    public static function get($followupId, $thorntonId)
    {
        $summaryThorntonSnoringScale = DentalsummfuTss::where('followupid', '=', $followupId)
            ->where('thorntonid', '=', $thorntonId)
            ->first();

        return $summaryThorntonSnoringScale;
    }

    public static function insertData($data)
    {
        $summaryThorntonSnoringScale = new DentalsummfuTss();

        foreach ($data as $attribute => $value) {
            $summaryThorntonSnoringScale->$attribute = $value;
        }

        $summaryThorntonSnoringScale->save();

        return $summaryThorntonSnoringScale->followupid;
    }

    public static function deleteData($followupId)
    {
        $summaryThorntonSnoringScale = DentalsummfuTss::where('followupid', '=', $followupId)->delete();

        return $summaryThorntonSnoringScale;
    }
}
