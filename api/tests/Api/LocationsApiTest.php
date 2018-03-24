<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Location;
use Tests\TestCases\ApiTestCase;

class LocationsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Location::class;
    }

    protected function getRoute()
    {
        return '/locations';
    }

    protected function getStoreData()
    {
        return [
            "location" => "totam",
            "docid" => 100,
            "name" => "Lisa Greenfelder",
            "address" => "786 Marina Forks\nBashirianmouth, MA 46917-9632",
            "city" => "Nicolasville",
            "state" => "NE",
            "zip" => "35520",
            "phone" => "9716618658",
            "fax" => "9924761393",
            "default_location" => 0,
            "email" => "vdeckow@gmail.com",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'location' => 'test location',
            'docid'    => 33,
            'name'     => 'John Doe',
        ];
    }

    public function testGetDoctorLocations()
    {
        $this->post(self::ROUTE_PREFIX . '/locations/by-doctor');
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }
}
