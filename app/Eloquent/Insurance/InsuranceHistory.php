<?php namespace Ds3\Eloquent\Insurance;

use Illuminate\Database\Eloquent\Model;

class InsuranceHistory extends Model
{
    protected $table = 'dental_insurance_history';
    protected $fillable = ['formid', 'patientid'];
    protected $primaryKey = 'id';

    public static function get($where)
    {
        $insuranceHistories = new InsuranceHistory();

        foreach ($where as $attribute => $value) {
            $insuranceHistories = $insuranceHistories->where($attribute, '=', $value);
        }

        return $insuranceHistories->get();
    }
}
