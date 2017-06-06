<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractDSSModel;
use DentalSleepSolutions\Contracts\Resources\PatientSummary as Resource;
use DentalSleepSolutions\Contracts\Repositories\PatientSummaries as Repository;

class PatientSummary extends AbstractDSSModel implements Resource, Repository
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'pid', 'fspage1_complete', 'next_visit',
        'last_visit', 'last_treatment', 'appliance',
        'delivery_date', 'vob', 'ledger', 'patient_info'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_patient_summary';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'pid';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function updateTrackerNotes($patientId = 0, $docId = 0, $notes = '')
    {
        return $this->from(\DB::raw('dental_patient_summary summary'))
            ->leftJoin(\DB::raw('dental_patients patient'), 'patient.patientid', '=', 'summary.pid')
            ->where('summary.pid', $patientId)
            ->where('patient.docid', $docId)
            ->update(['summary.tracker_notes' => $notes]);
    }

    public function getPatientInfo($patientId)
    {
        return $this->select('patient_info')
            ->where('pid', $patientId)
            ->first();
    }

    public function updatePatientSummary($patientId = 0, $data = [])
    {
        return $this->where('pid', $patientId)
            ->update($data);
    }
}
