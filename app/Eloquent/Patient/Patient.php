<?php namespace Ds3\Eloquent\Patient;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'dental_patients';
    protected $primaryKey = 'patientid';

    // public $timestamps = false;

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }

    public function scopeReferred($query)
    {
        return $query->where('referred_source', '=', 2);
    }

    public function scopeWithoutParent($query)
    {
        return $query->where(function($query){
            $query->whereNull('parent_patientid')
                ->orWhere('parent_patientid', '=', '');
        });
    }
}
