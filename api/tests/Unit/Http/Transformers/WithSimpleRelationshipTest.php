<?php

namespace Tests\Unit\Http\Requests;

use Tests\Dummies\Http\Transformers\WithSimpleRelationshipDummy;
use Tests\TestCases\UnitTestCase;

class WithSimpleRelationshipTest extends UnitTestCase
{
    const STRINGS = [
        'company' => 'Company',
        'address' => 'Address',
        'first' => 'First',
        'middle' => 'Middle',
        'last' => 'Last',
        'initial' => 'Initial',
    ];
    const EXTERNAL_REPRESENTATION = [
        'external_representation' => [
            'first' => [
                'company_name' => self::STRINGS['company'],
                'address1' => self::STRINGS['address'],
            ],
            'second' => [
                'lastname' => self::STRINGS['last'],
                'middlename' => self::STRINGS['middle'],
                'firstname' => self::STRINGS['first'],
                'title' => '',
            ],
        ],
    ];
    const INTERNAL_REPRESENTATION = [
        'internal_representation' => [
            'company' => self::STRINGS['company'],
            'address' => self::STRINGS['address'],
            'name' => [
                'first' => self::STRINGS['first'],
                'middle' => self::STRINGS['middle'],
                'last' => self::STRINGS['last'],
            ],
            'title' => '',
        ],
    ];
    const INITIAL_STATE = [
        'internal_representation' => [
            'initial' => self::STRINGS['initial'],
        ],
    ];
    const INTERNAL_REPRESENTATION_WITH_STATE = [
        'internal_representation' => [
            'initial' => self::STRINGS['initial'],
            'company' => self::STRINGS['company'],
            'address' => self::STRINGS['address'],
            'name' => [
                'first' => self::STRINGS['first'],
                'middle' => self::STRINGS['middle'],
                'last' => self::STRINGS['last'],
            ],
            'title' => '',
        ],
    ];

    public function testTransform()
    {
        $toMap = self::INTERNAL_REPRESENTATION;
        $toMap['internal_representation']['title'] = null;

        $transformer = new WithSimpleRelationshipDummy();
        $mapped = $transformer->simpleMapping($toMap, true);

        $this->assertEquals(self::EXTERNAL_REPRESENTATION, $mapped);
        $this->assertNotNull($mapped['external_representation']['second']['title']);
    }

    public function testInverseTransform()
    {
        $toMap = self::EXTERNAL_REPRESENTATION;
        $toMap['external_representation']['second']['title'] = null;

        $transformer = new WithSimpleRelationshipDummy();
        $mapped = $transformer->simpleMapping($toMap, false);

        $this->assertEquals(self::INTERNAL_REPRESENTATION, $mapped);
        $this->assertNotNull($mapped['internal_representation']['title']);
    }

    public function testInitialState()
    {
        $toMap = self::EXTERNAL_REPRESENTATION;
        $transformer = new WithSimpleRelationshipDummy();
        $mapped = $transformer->simpleMapping($toMap, false, self::INITIAL_STATE);

        $this->assertEquals(self::INTERNAL_REPRESENTATION_WITH_STATE, $mapped);
    }
}
