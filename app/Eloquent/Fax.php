<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Fax extends Model
{
    protected $table = 'dental_faxes';
    protected $primaryKey = 'id';

    public function scopeNonViewed($query)
    {
        return $query->where('viewed', '=', 0);
    }

    public function scopeWithError($query)
    {
        return $query->where('sfax_status', '=', 2);
    }
}
