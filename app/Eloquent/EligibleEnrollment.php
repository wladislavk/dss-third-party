<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class EligibleEnrollment extends Model
{
    protected $table = 'dental_eligible_enrollment';
    protected $fillable = ['user_id', 'payer_id', 'reference_id', 'response', 'status'];
    protected $primaryKey = 'id';

    public static function insertData($data)
    {
        $eligibleEnrollment = new EligibleEnrollment();

        foreach ($data as $attribute => $value) {
            $eligibleEnrollment->$attribute = $value;
        }

        try {
            $eligibleEnrollment->save();
        } catch (QueryException $e) {
            return null;
        }

        return $eligibleEnrollment->id;
    }
}
