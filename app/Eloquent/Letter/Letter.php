<?php namespace Ds3\Eloquent\Letter;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $table = 'dental_letters';
    protected $primaryKey = 'letterid';

    // public $timestamps = false;

    public function scopeNonDeleted($query)
    {
        return $query->where('deleted', '=', 0);
    }
}
