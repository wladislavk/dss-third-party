<?php
namespace Tests\Api;

use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Models\Dental\ContactType;

class ContactTypesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return ContactType::class;
    }

    protected function getRoute()
    {
        return '/contact-types';
    }

    protected function getStoreData()
    {
        return [
            'contacttype' => 'test',
            'description' => 'test description',
            'sortby'      => 10,
            'status'      => 10,
            'physician'   => 0,
            'corporate'   => 0,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'sortby'      => 10,
            'contacttype' => 'updated contact type',
        ];
    }
}
