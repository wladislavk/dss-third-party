<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Services\ContactOrderRetriever;
use Tests\TestCases\UnitTestCase;

class ContactOrderRetrieverTest extends UnitTestCase
{
    /** @var ContactOrderRetriever */
    private $contactOrderRetriever;

    public function setUp()
    {
        $this->contactOrderRetriever = new ContactOrderRetriever();
    }

    public function testGetOrderByColumnsWithEmpty()
    {
        $sort = '';
        $order = $this->contactOrderRetriever->getOrderByColumns($sort);
        $this->assertEquals([], $order);
    }

    public function testGetOrderByColumnsWithCompany()
    {
        $sort = 'company';
        $order = $this->contactOrderRetriever->getOrderByColumns($sort);
        $this->assertEquals(['company'], $order);

    }

    public function testGetOrderByColumnsWithType()
    {
        $sort = 'type';
        $order = $this->contactOrderRetriever->getOrderByColumns($sort);
        $this->assertEquals(['dct.contacttype'], $order);

    }

    public function testGetOrderByColumnsWithOther()
    {
        $sort = 'foo';
        $order = $this->contactOrderRetriever->getOrderByColumns($sort);
        $this->assertEquals(['dc.lastname', 'firstname'], $order);
    }

    public function testGetContactsOrderByColumnsWithType()
    {
        $sort = 'contacttype';
        $order = $this->contactOrderRetriever->getContactsOrderByColumns($sort);
        $this->assertEquals(['contacttype'], $order);
    }

    public function testGetContactsOrderByColumnsWithTotal()
    {
        $sort = 'total';
        $order = $this->contactOrderRetriever->getContactsOrderByColumns($sort);
        $this->assertEquals(['num_ref'], $order);
    }

    public function testGetContactsOrderByColumnsWithName()
    {
        $sort = 'name';
        $order = $this->contactOrderRetriever->getContactsOrderByColumns($sort);
        $this->assertEquals(['lastname', 'firstname'], $order);
    }

    public function testGetContactsOrderByColumnsWithOther()
    {
        $sort = 'foo';
        $order = $this->contactOrderRetriever->getContactsOrderByColumns($sort);
        $this->assertEquals([], $order);
    }

    public function testGetCorporateOrderByColumnsWithEmpty()
    {
        $sort = '';
        $order = $this->contactOrderRetriever->getCorporateOrderByColumns($sort);
        $this->assertEquals([], $order);
    }

    public function testGetCorporateOrderByColumnsWithCompany()
    {
        $sort = 'company';
        $order = $this->contactOrderRetriever->getCorporateOrderByColumns($sort);
        $this->assertEquals(['company'], $order);
    }

    public function testGetCorporateOrderByColumnsWithType()
    {
        $sort = 'type';
        $order = $this->contactOrderRetriever->getCorporateOrderByColumns($sort);
        $this->assertEquals(['ct.contacttype'], $order);
    }

    public function testGetCorporateOrderByColumnsWithOther()
    {
        $sort = 'foo';
        $order = $this->contactOrderRetriever->getCorporateOrderByColumns($sort);
        $this->assertEquals(['lastname', 'firstname'], $order);
    }
}
