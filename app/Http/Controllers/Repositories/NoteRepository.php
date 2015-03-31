<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\NoteInterface;
use Ds3\Eloquent\Note;

class NoteRepository implements NoteInterface
{
    public function findNote($notesId)
    {
        return Note::find($notesId);
    }

    public function getJoinNote($notesId)
    {
        $note = DB::table(DB::raw('dental_notes n'))
            ->select(DB::raw("n.*, CONCAT(u.first_name,' ',u.last_name) added_name"))
            ->leftJoin(DB::raw('dental_users u'), 'u.userid', '=', 'n.userid')
            ->where('notesid', '=', $notesId)
            ->first();

        return $note;
    }

    public function getJoinNotes($parentId, $notesId)
    {
        $notes = DB::table(DB::raw('dental_notes n'))
            ->select(DB::raw('n.parentid, u.name'))
            ->leftJoin(DB::raw('dental_users u'), 'n.userid', '=', 'u.userid')
            ->where('parentid', '=', $parentId)
            ->where('notesid', '!=', $notesId)
            ->get();

        return $notes;
    }

    public function getUnsigned($docId)
    {
        $unsigned = DB::table(DB::raw('(SELECT n.*, u.name signed_name, p.adddate AS parent_adddate FROM (SELECT * FROM dental_notes WHERE status != 0 AND docid = ' . $docId . ' ORDER BY adddate DESC) AS n
                                    LEFT JOIN dental_users u ON u.userid = n.signed_id
                                    LEFT JOIN dental_notes p ON p.notesid = n.parentid
                                    GROUP BY n.parentid
                                    ORDER BY n.procedure_date DESC, n.adddate DESC) AS m'))
            ->whereNull('m.signed_on')
            ->orWhere('m.signed_on', '=', '')
            ->get();

        return $unsigned;
    }

    public function insertData($data)
    {
        $note = new Note();

        foreach ($data as $attribute => $value) {
            $note->$attribute = $value;
        }

        try {
            $note->save();
        } catch (ModelNotFoundException $e) {
            return null;
        }

        return $note->notesid;
    }

    public function updateData($where, $condition, $values)
    {
        $note = new Note();

        if (strtolower($condition) == 'and') {
            foreach ($where as $attribute => $value) {
                $note = $note->where($attribute, '=', $value);
            }
        } else {
            foreach ($where as $attribute => $value) {
                $note = $note->orWhere($attribute, '=', $value);
            }
        }

        $note = $note->update($values);

        return $note;
    }
}
