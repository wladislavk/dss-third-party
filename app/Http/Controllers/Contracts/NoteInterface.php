<?php namespace Ds3\Contracts;

interface NoteInterface
{
    public function findNote($notesId);
    public function getJoinNote($notesId);
    public function getJoinNotes($parentId, $notesId);
    public function getUnsigned($docId);
    public function insertData($data);
    public function updateData($where, $condition, $values);
}
