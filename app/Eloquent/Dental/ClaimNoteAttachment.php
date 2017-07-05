<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\ClaimNoteAttachment as Resource;
use DentalSleepSolutions\Contracts\Repositories\ClaimNoteAttachments as Repository;

/**
 * @SWG\Definition(
 *     definition="ClaimNoteAttachment",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="note", type="integer"),
 *     @SWG\Property(property="filename", type="string"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment
 *
 * @property int $id
 * @property int|null $note_id
 * @property string|null $filename
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment whereNoteId($value)
 * @mixin \Eloquent
 */
class ClaimNoteAttachment extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'note_id', 'filename',
        'adddate', 'ip_address'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_claim_note_attachment';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
