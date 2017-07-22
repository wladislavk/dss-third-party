<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="ExternalPatient",
 *     type="object",
 *     @SWG\Property(property="externalCompany", ref="#/definitions/ExternalCompany"),
 *     @SWG\Property(property="patient", ref="#/definitions/Patient")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\ExternalPatient
 *
 * @property-read \DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany $externalCompany
 * @property-read \DentalSleepSolutions\Eloquent\Models\Dental\Patient $patient
 * @mixin \Eloquent
 */
class ExternalPatient extends AbstractModel
{
    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_external_patients';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patient () {
        return $this->hasOne(Patient::class, 'patientid', 'patient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function externalCompany()
    {
        return $this->belongsTo(ExternalCompany::class, 'company_id', 'id');
    }
}
