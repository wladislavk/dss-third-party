<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerPayment;
use Tests\TestCases\ApiTestCase;

class LedgerPaymentsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return LedgerPayment::class;
    }

    protected function getRoute()
    {
        return '/ledger-payments';
    }

    protected function getStoreData()
    {
        return [
            "payer" => 9,
            "amount" => 1176.5,
            "payment_type" => 2,
            "ledgerid" => 123,
            "allowed" => 171.18,
            "ins_paid" => 235.59,
            "deductible" => 123.14,
            "copay" => 346.02,
            "coins" => 237.34,
            "overpaid" => 634.26,
            "followup" => "1998-09-21 10:45:31",
            "note" => "In nesciunt quas accusamus et.",
            "amount_allowed" => 104.15,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'amount'   => 123.4,
            'ledgerid' => 3,
            'note'     => 'updated test ledger payment',
        ];
    }
}
