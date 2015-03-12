<?php namespace Ds3\Eloquent\Patient;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'dental_patients';
    protected $primaryKey = 'patientid';

    // public $timestamps = false;
}
