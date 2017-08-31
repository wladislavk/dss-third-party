<?php

namespace Tests\Unit\Http\Requests;

use Tests\Dummies\Http\Transformers\WithComplexRelationshipDummy;
use Tests\TestCases\UnitTestCase;

class WithComplexRelationshipTest extends UnitTestCase
{
    const ARRAYS = [
        'both' => [3, 4, 11, 36, 51, 100],
        'odd' => '0|3~2|11~4|51',
        'even' => '1|4~3|36~5|100',
    ];
    const STRINGS = [
        'flag' => 'Flag',
        'initial' => 'Initial',
        'simple' => 'Simple',
    ];
    const EXTERNAL_REPRESENTATION = [
        'external_representation' => [
            'empty' => '',
            'simple' => self::STRINGS['simple'],
            'nested' => [
                'flag' => self::STRINGS['flag'] . WithComplexRelationshipDummy::MARKER,
            ],
            'list' => [
                'both' => self::ARRAYS['both'],
            ],
        ],
    ];
    const INTERNAL_REPRESENTATION = [
        'internal_representation' => [
            'simple' => self::STRINGS['simple'],
            'flag' => self::STRINGS['flag'],
            'list' => [
                'odd' => self::ARRAYS['odd'],
                'even' => self::ARRAYS['even'],
            ],
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
            'simple' => self::STRINGS['simple'],
            'flag' => self::STRINGS['flag'],
            'list' => [
                'odd' => self::ARRAYS['odd'],
                'even' => self::ARRAYS['even'],
            ],
        ],
    ];

    public function testTransform()
    {
        $toMap = self::INTERNAL_REPRESENTATION;
        $transformer = new WithComplexRelationshipDummy();
        $mapped = $transformer->complexMapping($toMap, true);

        $this->assertEquals(self::EXTERNAL_REPRESENTATION, $mapped);
    }

    public function testInverseTransform()
    {
        $toMap = self::EXTERNAL_REPRESENTATION;
        $transformer = new WithComplexRelationshipDummy();
        $mapped = $transformer->complexMapping($toMap, false);

        $this->assertEquals(self::INTERNAL_REPRESENTATION, $mapped);
    }

    public function testInitialState()
    {
        $toMap = self::EXTERNAL_REPRESENTATION;
        $transformer = new WithComplexRelationshipDummy();
        $mapped = $transformer->complexMapping($toMap, false, self::INITIAL_STATE);

        $this->assertEquals(self::INTERNAL_REPRESENTATION_WITH_STATE, $mapped);
    }
}
