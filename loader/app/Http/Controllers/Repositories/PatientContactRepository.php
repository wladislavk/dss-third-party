<?php
namespace Ds3\Repositories;

use Ds3\Contracts\PatientContactInterface;
use Ds3\Eloquent\Patient\PatientContact;

class PatientContactRepository implements PatientContactInterface
{
    public function getPatientContacts($where)
    {
        $patientContact = PatientContact::join('dental_patients', 'dental_patients.patientid', '=', 'dental_patient_contacts.patientid');

        foreach ($where as $key => $value) {
            $patientContact = $patientContact->where($key, '=', $value);
        }

        return $patientContact->get();
    }
}
