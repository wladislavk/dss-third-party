<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Thorton extends Model
{
    protected $table = 'dental_thorton';
    protected $fillable = ['formid', 'patientid', 'userid', 'docid', 'status'];
    protected $primaryKey = 'thortonid';

    public static function get($patientId)
    {
        try {
            $thorton = Thorton::where('patientid', '=', $patientId)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return $thorton;
    }
}
