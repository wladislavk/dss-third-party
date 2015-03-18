<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class InsDiagnosis extends Model
{
    protected $table = 'dental_ins_diagnosis';
    protected $primaryKey = 'ins_diagnosisid';

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }
}
