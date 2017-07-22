<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientInsurance;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class PatientInsuranceRepository extends AbstractRepository
{
    public function model()
    {
        return PatientInsurance::class;
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return array
     */
    public function getCurrent($docId, $patientId)
    {
        return $this->model->from(\DB::raw('dental_patient_insurance pi'))
            ->select(\DB::raw('pi.*, p.firstname as patfirstname, p.lastname as patlastname'))
            ->join(\DB::raw('dental_patients p'), 'pi.patientid', '=', 'p.patientid')
            ->where('p.docid', $docId)
            ->where('p.patientid', $patientId)
            ->get();
    }

    /**
     * @param int $docId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getNumber($docId)
    {
        return $this->model->select(\DB::raw('COUNT(id) AS total'))
            ->from(\DB::raw('dental_patient_insurance pi'))
            ->join(\DB::raw('dental_patients p'), 'p.patientid', '=', 'pi.patientid')
            ->where('p.docid', $docId)
            ->first();
    }
}
