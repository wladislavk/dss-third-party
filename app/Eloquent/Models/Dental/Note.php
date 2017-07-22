<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="Note",
 *     type="object",
 *     required={"notesid", "editor_initials", "procedure_date"},
 *     @SWG\Property(property="notesid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="notes", type="string"),
 *     @SWG\Property(property="edited", type="integer"),
 *     @SWG\Property(property="editor_initials", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="procedure_date", type="string"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="signed_id", type="integer"),
 *     @SWG\Property(property="signed_on", type="string", format="dateTime"),
 *     @SWG\Property(property="parentid", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Note
 *
 * @property int $notesid
 * @property int|null $patientid
 * @property string|null $notes
 * @property int|null $edited
 * @property string $editor_initials
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string $procedure_date
 * @property string|null $ip_address
 * @property int|null $signed_id
 * @property \Carbon\Carbon|null $signed_on
 * @property int|null $parentid
 * @mixin \Eloquent
 */
class Note extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['notesid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_notes';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'notesid';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['signed_on'];

    const CREATED_AT = 'adddate';
}
