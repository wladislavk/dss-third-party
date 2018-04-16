<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\Form;
use Tests\TestCases\ApiTestCase;

class FormsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Form::class;
    }

    protected function getRoute()
    {
        return '/forms';
    }

    protected function getStoreData()
    {
        return [
            "docid" => 100,
            "patientid" => 4,
            "formtype" => 6,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'formtype' => 5,
            'docid'    => 7,
        ];
    }
}
