<?php
namespace Tests\ApiOld;

use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Models\Dental\ChangeList;

class ChangeListsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return ChangeList::class;
    }

    protected function getRoute()
    {
        return '/change-lists';
    }

    protected function getStoreData()
    {
        return ['content' => 'testContent'];
    }

    protected function getUpdateData()
    {
        return ['content' => 'updatedTestContent'];
    }
}
