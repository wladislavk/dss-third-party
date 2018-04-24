<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\CustomText;
use Tests\TestCases\ApiTestCase;

class CustomTextsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return CustomText::class;
    }

    protected function getRoute()
    {
        return '/custom-texts';
    }

    protected function getStoreData()
    {
        return [
            'title'        => 'test title custom',
            'description'  => 'added test description custom',
            'docid'        => 10,
            'status'       => 2,
            'default_text' => 2,
        ];
    }

    protected function getUpdateData()
    {
        return ['description' => 'updatedTestDescriptionCustom'];
    }
}
