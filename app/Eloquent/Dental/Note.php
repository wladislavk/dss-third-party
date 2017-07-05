<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Note as Resource;
use DentalSleepSolutions\Contracts\Repositories\Notes as Repository;
use DB;

/**
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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereEdited($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereEditorInitials($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereNotesid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereParentid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Note wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereProcedureDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereSignedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereSignedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereUserid($value)
 * @mixin \Eloquent
 */
class Note extends AbstractModel implements Resource, Repository
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

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function getUnsigned($docId = 0)
    {
        return $this->select(DB::raw('COUNT(m.notesid) AS total'))
            ->from(DB::raw("
                (
                    SELECT n.*
                    FROM (
                        SELECT
                            notesid,
                            signed_on,
                            signed_id,
                            parentid,
                            procedure_date
                        FROM dental_notes
                        WHERE status != 0
                            AND docid = ?
                        ORDER BY adddate DESC
                    ) AS n
                    LEFT JOIN dental_users u ON u.userid = n.signed_id
                    LEFT JOIN dental_notes p ON p.notesid = n.parentid
                    GROUP BY n.parentid
                ) AS m
                "))
            ->addBinding($docId, 'select')
            ->whereRaw("COALESCE(m.signed_on, '') = ''")
            ->first();
    }
}
