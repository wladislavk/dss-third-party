<?php namespace Ds3\Eloquent\Patient;

use Illuminate\Database\Eloquent\Model;

class PatientContact extends Model
{
	protected $table = 'dental_patient_contacts';

	protected $primaryKey = 'id';
}