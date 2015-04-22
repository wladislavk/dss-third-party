<?php
namespace Ds3\Eloquent\Dentalsummfu;

use Illuminate\Database\Eloquent\Model;

class Dentalsummfu extends Model
{
    protected $table = 'dentalsummfu';
    protected $fillable = ['patientid', 'devadd', 'dsetadd'];
    protected $primaryKey = 'followupid';

    public static function get($patientId, $order)
    {
        $summaryFollowUp = Dentalsummfu::where('patientid', '=', $patientId)
            ->orderBy($order, 'desc')
            ->get();

        return $summaryFollowUp;
    }

    public static function updateData($followupId, $values)
    {
        $summaryFollowUp = Dentalsummfu::where('followupid', '=', $followupId)->update($values);

        return $summaryFollowUp;
    }

    public static function insertData($data)
    {
        $summaryFollowUp = new Dentalsummfu();

        foreach ($data as $attribute => $value) {
            $summaryFollowUp->$attribute = $value;
        }

        $summaryFollowUp->save();

        return $summaryFollowUp->followupid;
    }

    public static function deleteData($followupId)
    {
        $summaryFollowUp = Dentalsummfu::where('followupid', '=', $followupId)->delete();

        return $summaryFollowUp;
    }
}
