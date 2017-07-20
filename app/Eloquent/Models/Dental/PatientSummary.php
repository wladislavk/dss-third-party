<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\Resource;

/**
 * @SWG\Definition(
 *     definition="PatientSummary",
 *     type="object",
 *     required={"pid", "tracker_notes"},
 *     @SWG\Property(property="pid", type="integer"),
 *     @SWG\Property(property="fspage1_complete", type="integer"),
 *     @SWG\Property(property="next_visit", type="string"),
 *     @SWG\Property(property="last_visit", type="string"),
 *     @SWG\Property(property="last_treatment", type="string"),
 *     @SWG\Property(property="appliance", type="integer"),
 *     @SWG\Property(property="delivery_date", type="string"),
 *     @SWG\Property(property="vob", type="string"),
 *     @SWG\Property(property="ledger", type="float"),
 *     @SWG\Property(property="patient_info", type="integer"),
 *     @SWG\Property(property="tracker_notes", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\PatientSummary
 *
 * @property int $pid
 * @property int|null $fspage1_complete
 * @property string|null $next_visit
 * @property string|null $last_visit
 * @property string|null $last_treatment
 * @property int|null $appliance
 * @property string|null $delivery_date
 * @property string|null $vob
 * @property float|null $ledger
 * @property int|null $patient_info
 * @property string $tracker_notes
 * @mixin \Eloquent
 */
class PatientSummary extends AbstractModel implements Resource
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
        return $this->from(DB::raw('dental_patient_summary summary'))
            ->leftJoin(DB::raw('dental_patients patient'), 'patient.patientid', '=', 'summary.pid')
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
