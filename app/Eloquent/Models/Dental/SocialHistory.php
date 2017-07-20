<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;

/**
 * @SWG\Definition(
 *     definition="SocialHistory",
 *     type="object",
 *     required={"q_page4id"},
 *     @SWG\Property(property="q_page4id", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="family_had", type="string"),
 *     @SWG\Property(property="family_diagnosed", type="string"),
 *     @SWG\Property(property="additional_paragraph", type="string"),
 *     @SWG\Property(property="alcohol", type="string"),
 *     @SWG\Property(property="sedative", type="string"),
 *     @SWG\Property(property="caffeine", type="string"),
 *     @SWG\Property(property="smoke", type="string"),
 *     @SWG\Property(property="smoke_packs", type="string"),
 *     @SWG\Property(property="tobacco", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="parent_patientid", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\SocialHistory
 *
 * @property int $q_page4id
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $family_had
 * @property string|null $family_diagnosed
 * @property string|null $additional_paragraph
 * @property string|null $alcohol
 * @property string|null $sedative
 * @property string|null $caffeine
 * @property string|null $smoke
 * @property string|null $smoke_packs
 * @property string|null $tobacco
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $parent_patientid
 * @mixin \Eloquent
 */
class SocialHistory extends AbstractModel implements Resource
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['q_page4id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_q_page4';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'q_page4id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
