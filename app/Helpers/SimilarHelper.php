<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;

// this class contains all functions from includes/similar.php
class SimilarHelper
{
    /** @var Patient */
    private $patientModel;

    public function __construct(Patient $patient)
    {
        $this->patientModel = $patient;
    }

    /**
     * @param int $patientId
     * @param int $docId
     * @return array
     */
    public function getSimilarPatients($patientId, $docId)
    {
        /** @var Patient|null $foundPatient */
        $foundPatient = $this->patientModel->find($patientId);

        $patientInfo = [];
        if ($foundPatient) {
            $patientInfo = $this->populatePatientInfo($foundPatient);
        }

        $similarPatients = $this->patientModel->getSimilarPatients($docId, $patientInfo);
        $docs = [];
        foreach ($similarPatients as $patient) {
            $fullName = $patient->firstname . ' ' . $patient->lastname;
            $address = $this->formAddress($patient);
            $docs[] = [
                'id'      => $patient->patientid,
                'name'    => $fullName,
                'address' => $address,
            ];
        }
        return $docs;
    }

    /**
     * @param Patient $foundPatient
     * @return array
     */
    private function populatePatientInfo(Patient $foundPatient)
    {
        $patientInfo = [
            'patient_id' => $foundPatient->patientid,
            'firstname'  => $foundPatient->firstname,
            'lastname'   => $foundPatient->lastname,
            'add1'       => $foundPatient->add1,
            'city'       => $foundPatient->city,
            'state'      => $foundPatient->state,
            'zip'        => $foundPatient->zip,
        ];
        return $patientInfo;
    }

    /**
     * @param Patient $patient
     * @return string
     */
    private function formAddress(Patient $patient)
    {
        $addressFields = [$patient->add1];
        if ($patient->add2) {
            $addressFields[] = $patient->add2;
        }
        if ($patient->city) {
            $addressFields[] = $patient->city;
        }
        if ($patient->state) {
            $addressFields[] = $patient->state;
        }
        if ($patient->zip) {
            $addressFields[] = $patient->zip;
        }
        $fullAddress = join(' ', $addressFields);
        return $fullAddress;
    }
}
