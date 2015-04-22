<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'dental_device';
    protected $primaryKey = 'deviceid';

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }
}
