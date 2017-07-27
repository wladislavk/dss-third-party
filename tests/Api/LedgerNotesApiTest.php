<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\LedgerNote;
use Tests\TestCases\ApiTestCase;

class LedgerNotesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return LedgerNote::class;
    }

    protected function getRoute()
    {
        return '/ledger-notes';
    }

    protected function getStoreData()
    {
        return [
            "producerid" => 100,
            "note" => "Commodi et accusamus.",
            "private" => 2,
            "patientid" => 5,
            "docid" => 4,
            "admin_producerid" => 7,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'note'    => 'updated note',
            'private' => 8,
        ];
    }
}
