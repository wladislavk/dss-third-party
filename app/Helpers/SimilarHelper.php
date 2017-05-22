<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;

// this class contains all functions from includes\similar.php
class SimilarHelper
{
    private $patient;

    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    public function getSimilarPatients($patientId, $docId)
    {
        /** @var Patient $foundPatient */
        $foundPatient = $this->patient->find($patientId);

        if (!empty($foundPatient)) {
            $patientInfo = [
                'patient_id' => $patientId,
                'firstname'  => $foundPatient->firstname,
                'lastname'   => $foundPatient->lastname,
                'add1'       => $foundPatient->add1,
                'city'       => $foundPatient->city,
                'state'      => $foundPatient->state,
                'zip'        => $foundPatient->zip
            ];
        } else {
            $patientInfo = [];
        }

        $similarPatients = $this->patient->getSimilarPatients($docId, $patientInfo);
        $docs = [];
        if (count($similarPatients)) {
            foreach ($similarPatients as $patient) {
                $address = $patient->add1 . (!empty($patient->add2) ? ' ' . $patient->add2 : '')
                        . (!empty($patient->city) ? ' ' . $patient->city : '')
                        . (!empty($patient->state) ? ' ' . $patient->state : '')
                        . (!empty($patient->zip) ? ' ' . $patient->zip : '');

                $docs[] = [
                    'id'      => $patient->patientid,
                    'name'    => $patient->firstname . ' ' . $patient->lastname,
                    'address' => $address
                ];
            }
        }

        return $docs;
    }
}
