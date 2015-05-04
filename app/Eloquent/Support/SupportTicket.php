<?php
namespace Ds3\Eloquent\Support;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $table = 'dental_support_tickets';
    protected $primaryKey = 'id';
    // public $timestamps = false;

    public function scopeNonCreated($query)
    {
        return $query->where('create_type', '=', 0);
    }
}
