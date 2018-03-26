<?php
namespace Ds3\Eloquent\Dentalsummfu;

use Illuminate\Database\Eloquent\Model;

class DentalsummfuEss extends Model
{
    protected $table = 'dentalsummfu_ess';
    protected $fillable = ['followupid', 'epworthid', 'answer'];
    protected $primaryKey = 'id';

    public static function insertData($data)
    {
        $summaryEpworthSleep = new DentalsummfuEss();

        foreach ($data as $attribute => $value) {
            $summaryEpworthSleep->$attribute = $value;
        }

        $summaryEpworthSleep->save();

        return $summaryEpworthSleep->followupid;
    }

    public static function deleteData($followupId)
    {
        $summaryEpworthSleep = DentalsummfuEss::where('followupid', '=', $followupId)->delete();

        return $summaryEpworthSleep;
    }
}
