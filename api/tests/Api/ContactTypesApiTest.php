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

    public function testGetActiveNonCorporate()
    {
        $this->post(self::ROUTE_PREFIX . '/contact-types/active-non-corporate');
        $this->assertResponseOk();
        $expected = [
            [
                'contacttypeid' => 20,
                'contacttype' => 'Primary Care Physician',
            ],
            [
                'contacttypeid' => 21,
                'contacttype' => 'Sleep Physician',
            ],
            [
                'contacttypeid' => 24,
                'contacttype' => 'Dentist',
            ],
            [
                'contacttypeid' => 22,
                'contacttype' => 'ENT Physician',
            ],
            [
                'contacttypeid' => 23,
                'contacttype' => 'Other Physician',
            ],
            [
                'contacttypeid' => 12,
                'contacttype' => 'Other',
            ],
            [
                'contacttypeid' => 19,
                'contacttype' => 'Unknown',
            ],
            [
                'contacttypeid' => 14,
                'contacttype' => 'Patient',
            ],
            [
                'contacttypeid' => 13,
                'contacttype' => 'Parent',
            ],
            [
                'contacttypeid' => 11,
                'contacttype' => 'Insurance',
            ],
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testGetPhysician()
    {
        $this->post(self::ROUTE_PREFIX . '/contact-types/physician');
        $this->assertResponseOk();
        $expected = [
            'physician_types' => '20,21,22,23,24',
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testGetWithFilter()
    {
        $this->post(self::ROUTE_PREFIX . '/contact-types/with-filter');
        $this->assertResponseOk();
        $this->assertEquals(11, count($this->getResponseData()));
        $expectedFirst = [
            'contacttypeid' => 25,
            'contacttype' => 'test corporate type',
            'description' => 'testing corp description',
            'sortby' => 999,
            'status' => 1,
            'adddate' => '2014-03-18 23:07:41',
            'ip_address' => '68.253.133.237',
            'physician' => 0,
            'corporate' => 1,
        ];
        $this->assertEquals($expectedFirst, $this->getResponseData()[0]);
    }

    public function testGetSortedContactTypes()
    {
        $this->post(self::ROUTE_PREFIX . '/contact-types/sorted');
        $this->assertResponseOk();
        $this->assertEquals(11, count($this->getResponseData()));
        $expectedFirst = [
            'contacttypeid' => 20,
            'contacttype' => 'Primary Care Physician',
            'description' => '',
            'sortby' => 1,
            'status' => 1,
            'adddate' => '2011-04-14 22:12:43',
            'ip_address' => '72.77.128.163',
            'physician' => 1,
            'corporate' => 0,
        ];
        $this->assertEquals($expectedFirst, $this->getResponseData()[0]);
    }
}
