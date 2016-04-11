<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\PercaseInvoice as Resource;
use DentalSleepSolutions\Contracts\Repositories\PercaseInvoices as Repository;

use Carbon\Carbon;

class PercaseInvoice extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_percase_invoice';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['monthly_fee_date', 'due_date', 'user_fee_date', 'producer_fee_date'];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

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
