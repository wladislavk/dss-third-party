<?php
namespace Ds3\Eloquent\Patient;

use Illuminate\Database\Eloquent\Model;

class PatientInsurance extends Model
{
    protected $table = 'dental_patient_insurance';
    protected $primaryKey = 'id';
}
