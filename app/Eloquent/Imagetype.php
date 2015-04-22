<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Imagetype extends Model
{
    protected $table = 'dental_imagetype';
    protected $primaryKey = 'imagetypeid';

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }
}
