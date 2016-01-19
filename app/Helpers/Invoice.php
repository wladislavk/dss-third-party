<?php

namespace DentalSleepSolutions\Helpers;

use Exception;
use DentalSleepSolutions\Eloquent\Dental\PercaseInvoice;
use DentalSleepSolutions\Eloquent\Enrollments\Enrollment;
use DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice;

class Invoice
{
    /** invoice status */
    const DSS_INVOICE_PENDING = 4;
    const DSS_INVOICE_INVOICED = 0;
    const DSS_INVOICE_PAID = 1;
    const DSS_INVOICE_ERROR = 2;
    const DSS_INVOICE_PAYMENT_ERROR = 3;

    /** invoice type */
    const DSS_INVOICE_TYPE_SU_FO = 1; //Super invoices front office
    const DSS_INVOICE_TYPE_BC_FO = 2; //Billing company invoices front office
    const DSS_INVOICE_TYPE_SU_BC = 3; //Super invoices billing company

    /**
     * Find existing pending invoice for user
     *
     * @param int $user_type
     * @param int $user_id
     * @param int $inv_type
     * @return int
     * @throws \Exception
     */
    public static function find($user_type, $user_id, $inv_type = null)
    {
        if (!$inv_type) {
            $inv_type = self::DSS_INVOICE_TYPE_SU_FO;
        }

        if ($user_type == '1') {
            $column = 'docid';
            $invoice_type = $inv_type;
        } elseif ($user_type == '2') {
            $column = 'companyid';
            $invoice_type = self::DSS_INVOICE_TYPE_SU_BC;
        } else {
            throw new Exception('Invoice::find error');
        }

        $inv_id = PercaseInvoice::getInvoiceId($column, $user_id, $invoice_type, self::DSS_INVOICE_PENDING);

        if (!$inv_id) {
            $inv_id = PercaseInvoice::add(
                $column,
                $user_id,
                $invoice_type,
                self::DSS_INVOICE_PENDING,
                request()->server('REMOTE_ADDR')
            );
        }

        return $inv_id;
    }

    /**
     * add invoice when enrollment is added
     *
     * @param int $user_type
     * @param int $user_id
     * @param int $eid
     * @return bool
     * @throws \Exception
     */
    public static function addEnrollment($user_type, $user_id, $eid)
    {
        if ($user_type == '1') {
            $column = 'companyid';
        } elseif ($user_type == '2') {
            $column = 'docid';
        } else {
            throw new Exception('Invoice::addEnrollment error');
        }

        $invoice_id = PercaseInvoice::getInvoiceIdWithEnrollmentInvoice(
            $column,
            $user_id,
            self::DSS_INVOICE_PENDING
        );

        if (!$invoice_id) {
            $inv_id = self::find($user_type, $user_id);
            $invoice_id = EnrollmentInvoice::add($inv_id, request()->server('REMOTE_ADDR'));
        }

        $enrollment = Enrollment::find($eid);
        $enrollment->enrollment_invoice_id = $invoice_id;

        return $enrollment->save();
    }
}
