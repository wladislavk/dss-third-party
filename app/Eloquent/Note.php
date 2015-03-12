<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'dental_notes';
    protected $primaryKey = 'notesid';
}
