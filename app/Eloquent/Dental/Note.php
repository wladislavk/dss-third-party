<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Note as Resource;
use DentalSleepSolutions\Contracts\Repositories\Notes as Repository;
use DB;

class Note extends Model implements Resource, Repository
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
