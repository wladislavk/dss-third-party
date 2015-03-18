<?php namespace Ds3\Eloquent\Insurance;

use Illuminate\Database\Eloquent\Model;

class InsurancePreauth extends Model
{
    protected $table = 'dental_insurance_preauth';
    protected $primaryKey = 'id';

    public function scopeNonViewed($query)
    {
        return $query->where(function($query){
            $query->whereNull('viewed')
                ->orWhere('viewed', '!=', 1);
        });
    }
}
