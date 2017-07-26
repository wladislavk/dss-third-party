<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientContact;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class PatientContactRepository extends AbstractRepository
{
    public function model()
    {
        return PatientContact::class;
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return array
     */
    public function getCurrent($docId, $patientId)
    {
        return $this->model->from(\DB::raw('dental_patient_contacts pc'))
            ->select(\DB::raw('pc.id, pc.contacttype, pc.firstname, pc.lastname, pc.address1,'
                . 'pc.address2, pc.city, pc.state, pc.zip, pc.phone, p.firstname as patfirstname,'
                . 'p.lastname as patlastname'))
            ->join(\DB::raw('dental_patients p'), 'pc.patientid', '=', 'p.patientid')
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
            ->from(\DB::raw('dental_patient_contacts pc'))
            ->join(\DB::raw('dental_patients p'), 'p.patientid', '=', 'pc.patientid')
            ->where('p.docid', $docId)
            ->first();
    }
}
