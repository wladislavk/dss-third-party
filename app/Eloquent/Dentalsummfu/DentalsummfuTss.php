<?php namespace Ds3\Eloquent\Dentalsummfu;

use Illuminate\Database\Eloquent\Model;

class DentalsummfuTss extends Model
{
    protected $table = 'dentalsummfu_tss';
    protected $fillable = ['followupid', 'thorntonid', 'answer'];
    protected $primaryKey = 'id';

    public static function get($followupId, $thorntonId)
    {
        try {
            $dentalsummfuTss = DentalsummfuTss::where('followupid', '=', $followupId)
                ->where('thorntonid', '=', $thorntonId)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return $dentalsummfuTss;
    }

    public static function insertData($data)
    {
        $dentalsummfuTss = new DentalsummfuTss();

        foreach ($data as $attribute => $value) {
            $dentalsummfuTss->$attribute = $value;
        }

        try {
            $dentalsummfuTss->save();
        } catch (QueryException $e) {
            return null;
        }

        return $dentalsummfuTss->followupid;
    }

    public static function deleteData($followupId)
    {
        $dentalsummfuTss = DentalsummfuTss::where('followupid', '=', $followupId)->delete();

        return $dentalsummfuTss;
    }
}
