<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Note;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class NoteRepository extends AbstractRepository
{
    public function model()
    {
        return Note::class;
    }

    /**
     * @param int $docId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getUnsigned($docId)
    {
        return $this->model->select(\DB::raw('COUNT(m.notesid) AS total'))
            ->from(\DB::raw("
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
