<?php namespace Ds3\Eloquent\Patient;

use Illuminate\Database\Eloquent\Model;

class PatientSummary extends Model
{
    protected $table = 'dental_patient_summary';
    protected $primaryKey = 'id';

    // public $timestamps = false;
}
