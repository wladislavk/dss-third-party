<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PercaseInvoice extends Model
{
    protected $table = 'dental_percase_invoice';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * get enrolment_invoice id
     *
     * @param $column
     * @param $user_id
     * @param $status
     * @return bool
     */
    public static function getInvoiceIdWithEnrollmentInvoice($column, $user_id, $status)
    {
        $result = self::select(['dental_percase_invoice.id'])
            ->join(
                'dental_enrollment_invoice',
                'dental_enrollment_invoice.invoice_id',
                '=',
                'dental_percase_invoice.id'
            )
            ->where('dental_percase_invoice.'.$column, $user_id)
            ->where('dental_percase_invoice.status', $status)
            ->first();

        if ($result) {
            return $result->id;
        }

        return false;
    }

    /**
     * get enrolment_invoice id
     *
     * @param $column
     * @param $user_id
     * @param $invoice_type
     * @param $status
     * @return bool
     */
    public static function getInvoiceId($column, $user_id, $invoice_type, $status)
    {
        $result = self::select(['id'])
            ->where($column, $user_id)
            ->where('invoice_type', $invoice_type)
            ->where('status', $status)
            ->first();

        if ($result) {
            return $result->id;
        }

        return false;
    }

    /**
     * create new record
     *
     * @param $column
     * @param $user_id
     * @param $invoice_type
     * @param $status
     * @param $ip
     * @return mixed
     */
    public static function add($column, $user_id, $invoice_type, $status, $ip)
    {
        $percase_invoice = new static;
        $percase_invoice->{$column} = $user_id;
        $percase_invoice->status = $status;
        $percase_invoice->invoice_type = $invoice_type;
        $percase_invoice->adddate = Carbon::now();
        $percase_invoice->ip_address = $ip;
        $percase_invoice->save();

        return $percase_invoice->id;
    }
}
