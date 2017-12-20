<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ClaimNote;
use Tests\TestCases\ApiTestCase;

class ClaimNotesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return ClaimNote::class;
    }

    protected function getRoute()
    {
        return '/claim-notes';
    }

    protected function getStoreData()
    {
        return [
            'claim_id'    => 5,
            'create_type' => 0,
            'creator_id'  => 5,
            'note'        => 'testNote',
        ];
    }

    protected function getUpdateData()
    {
        return [
            'note' => 'updatedTestNote',
        ];
    }
}
