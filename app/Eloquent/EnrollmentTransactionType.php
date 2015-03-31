<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class EnrollmentTransactionType extends Model
{
    protected $table = 'dental_enrollment_transaction_type';
    protected $fillable = ['transaction_type', 'description', 'status'];
    protected $primaryKey = 'id';

    public static function get($id)
    {
        try {
            $enrollmentTransactionType = EnrollmentTransactionType::where('id', '=', $id)
                ->where('status', '=', 1)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return $enrollmentTransactionType;
    }

    public static function getTransactionTypes()
    {
        $transactionTypes = EnrollmentTransactionType::where('status', '=', 1)
            ->orderBy('transaction_type')
            ->get();

        return $transactionTypes;
    }
}
