<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\AbstractModel;

/**
 * DentalSleepSolutions\Eloquent\Dental\PercaseInvoice
 *
 * @property int $id
 * @property int|null $adminid
 * @property int|null $docid
 * @property string|null $adddate
 * @property string|null $ip_address
 * @property string|null $monthly_fee_date
 * @property float|null $monthly_fee_amount
 * @property int|null $status
 * @property string|null $due_date
 * @property int|null $companyid
 * @property string|null $user_fee_date
 * @property float|null $user_fee_amount
 * @property string|null $producer_fee_date
 * @property float|null $producer_fee_amount
 * @property string|null $user_fee_desc
 * @property string|null $producer_fee_desc
 * @property int|null $invoice_type
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereAdminid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereCompanyid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereInvoiceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereMonthlyFeeAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereMonthlyFeeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereProducerFeeAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereProducerFeeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereProducerFeeDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereUserFeeAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereUserFeeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereUserFeeDesc($value)
 * @mixin \Eloquent
 */
class PercaseInvoice extends AbstractModel
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
