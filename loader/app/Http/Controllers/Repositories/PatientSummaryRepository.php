<?php
namespace Ds3\Repositories;

use Illuminate\Support\Facades\DB;

use Ds3\Contracts\PatientSummaryInterface;
use Ds3\Eloquent\Patient\PatientSummary;

class PatientSummaryRepository implements PatientSummaryInterface
{
    public function getPatientSummary($where)
    {
        $patientSummary = new PatientSummary();

        foreach ($where as $attribute => $value) {
            $patientSummary = $patientSummary->where($attribute, '=', $value);
        }

        return $patientSummary->get();
    }

    public function updateData($patientId, $values)
    {
        $patientSummary = PatientSummary::where('pid', '=', $patientId)->update($values);

        return $patientSummary;
    }

    public function insertData($data)
    {
        $patientSummary = new PatientSummary();

        foreach ($data as $attribute => $value) {
            $patientSummary->$attribute = $value;
        }

        $patientSummary->save();

        return $patientSummary->id;
    }
}
