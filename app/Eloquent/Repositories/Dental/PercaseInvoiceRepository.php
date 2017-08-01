<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\PercaseInvoice;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class PercaseInvoiceRepository extends AbstractRepository
{
    public function model()
    {
        return PercaseInvoice::class;
    }

    /**
     * @param string $column
     * @param int $userId
     * @param int $status
     * @return int|bool
     */
    public function getInvoiceIdWithEnrollmentInvoice($column, $userId, $status)
    {
        $result = $this->model->select(['dental_percase_invoice.id'])
            ->join(
                'dental_enrollment_invoice',
                'dental_enrollment_invoice.invoice_id',
                '=',
                'dental_percase_invoice.id'
            )
            ->where('dental_percase_invoice.' . $column, $userId)
            ->where('dental_percase_invoice.status', $status)
            ->first();

        if ($result) {
            return $result->id;
        }

        return false;
    }

    /**
     * @param string $column
     * @param int $userId
     * @param int $invoiceType
     * @param int $status
     * @return bool|int
     */
    public function getInvoiceId($column, $userId, $invoiceType, $status)
    {
        $result = $this->model->select(['id'])
            ->where($column, $userId)
            ->where('invoice_type', $invoiceType)
            ->where('status', $status)
            ->first();

        if ($result) {
            return $result->id;
        }

        return false;
    }

    /**
     * @param string $column
     * @param int $userId
     * @param int $invoiceType
     * @param int $status
     * @param string $ip
     * @return int
     */
    public function add($column, $userId, $invoiceType, $status, $ip)
    {
        $percaseInvoice = new PercaseInvoice();
        $percaseInvoice->{$column} = $userId;
        $percaseInvoice->status = $status;
        $percaseInvoice->invoice_type = $invoiceType;
        $percaseInvoice->adddate = Carbon::now();
        $percaseInvoice->ip_address = $ip;
        $percaseInvoice->save();

        return $percaseInvoice->id;
    }
}
