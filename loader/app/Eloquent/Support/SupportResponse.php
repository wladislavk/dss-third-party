<?php
namespace Ds3\Eloquent\Support;

use Illuminate\Database\Eloquent\Model;

class SupportResponse extends Model
{
    protected $table = 'dental_support_responses';
    protected $primaryKey = 'id';
    // public $timestamps = false;

    public function scopeNoResponse($query)
    {
        return $query->where('response_type', '=', 0);
    }
}
