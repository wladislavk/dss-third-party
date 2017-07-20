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
     * RELATIONS
     */
    public function patient () {
        return $this->hasOne(Patient::class, 'patientid', 'patient_id');
    }

    public function externalCompany()
    {
        return $this->belongsTo(ExternalCompany::class, 'company_id', 'id');
    }

    public function getWithFilter($fields = [], $where = [])
    {
        $object = $this;

        if (count($fields)) {
            $object = $object->select($fields);
        }

        if (count($where)) {
            foreach ($where as $key => $value) {
                $object = $object->where($key, $value);
            }
        }

        return $object->get();
    }
}
