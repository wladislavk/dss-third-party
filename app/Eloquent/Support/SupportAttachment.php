<?php
namespace Ds3\Eloquent\Support;

use Illuminate\Database\Eloquent\Model;

class SupportAttachment extends Model
{
    protected $table = 'dental_support_attachment';
    protected $fillable = ['ticket_id', 'response_id', 'filename'];
    protected $primaryKey = 'id';
    // public $timestamps = false;
}
