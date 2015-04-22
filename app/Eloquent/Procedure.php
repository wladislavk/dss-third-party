<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    protected $table = 'dental_procedure';
    protected $fillable = ['patientid', 'insuranceid', 'place_service', 'type_service'];
    protected $primaryKey = 'procedureid';

    public static function get($procedureId)
    {
        $procedure = Procedure::where('procedureid', '=', $procedureId)->first();

        return $procedure;
    }

    public static function updateData($procedureId, $values)
    {
        $procedure = Procedure::where('procedureid', '=', $procedureId)->update($values);

        return $procedure;
    }

    public static function insertData($data)
    {
        $procedure = new Procedure();

        foreach ($data as $attribute => $value) {
            $procedure->$attribute = $value;
        }

        $procedure->save();

        return $procedure->procedureid;
    }
}
