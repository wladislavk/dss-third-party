<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Thorton extends Model
{
    protected $table = 'dental_thorton';
    protected $fillable = ['formid', 'patientid', 'userid', 'docid', 'status'];
    protected $primaryKey = 'thortonid';

    public static function get($patientId)
    {
        $thorton = Thorton::where('patientid', '=', $patientId)->first();

        return $thorton;
    }
}
