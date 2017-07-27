<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="Procedure",
 *     type="object",
 *     required={"procedureid"},
 *     @SWG\Property(property="procedureid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="insuranceid", type="integer"),
 *     @SWG\Property(property="service_date_from", type="string"),
 *     @SWG\Property(property="service_date_to", type="string"),
 *     @SWG\Property(property="place_service", type="string"),
 *     @SWG\Property(property="type_service", type="string"),
 *     @SWG\Property(property="cpt_code", type="string"),
 *     @SWG\Property(property="units", type="string"),
 *     @SWG\Property(property="charge", type="string"),
 *     @SWG\Property(property="total_charge", type="string"),
 *     @SWG\Property(property="applies_icd", type="string"),
 *     @SWG\Property(property="npi", type="string"),
 *     @SWG\Property(property="other_id", type="string"),
 *     @SWG\Property(property="other_id_qualifier", type="string"),
 *     @SWG\Property(property="modifier_code_1", type="string"),
 *     @SWG\Property(property="modifier_code_2", type="string"),
 *     @SWG\Property(property="modifier_code_3", type="string"),
 *     @SWG\Property(property="modifier_code_4", type="string"),
 *     @SWG\Property(property="epsdt", type="string"),
 *     @SWG\Property(property="emg", type="string"),
 *     @SWG\Property(property="supplemental_info", type="string"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Procedure
 *
 * @property int $procedureid
 * @property int|null $patientid
 * @property int|null $insuranceid
 * @property string|null $service_date_from
 * @property string|null $service_date_to
 * @property string|null $place_service
 * @property string|null $type_service
 * @property string|null $cpt_code
 * @property string|null $units
 * @property string|null $charge
 * @property string|null $total_charge
 * @property string|null $applies_icd
 * @property string|null $npi
 * @property string|null $other_id
 * @property string|null $other_id_qualifier
 * @property string|null $modifier_code_1
 * @property string|null $modifier_code_2
 * @property string|null $modifier_code_3
 * @property string|null $modifier_code_4
 * @property string|null $epsdt
 * @property string|null $emg
 * @property string|null $supplemental_info
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @mixin \Eloquent
 */
class Procedure extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['procedureid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_procedure';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'procedureid';

    const CREATED_AT = 'adddate';
}
