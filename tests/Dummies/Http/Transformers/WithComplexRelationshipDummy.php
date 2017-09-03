<?php

namespace Tests\Dummies\Http\Transformers;

use DentalSleepSolutions\Contracts\ComplexRelationshipInterface;
use DentalSleepSolutions\Http\Transformers\WithComplexRelationship;

class WithComplexRelationshipDummy implements ComplexRelationshipInterface
{
    use WithComplexRelationship;

    const COMPLEX_MAP = [
        'external_representation.empty' => [],
        'external_representation.simple' => 'internal_representation.simple',
        'external_representation.nested.flag' => [
            'internal_representation.flag' => 'exportFlagCallback',
        ],
        'external_representation.list.both' => [
            'internal_representation.list.odd' => 'exportListCallback',
            'internal_representation.list.even' => 'exportListCallback',
        ],
    ];
    const INVERSE_COMPLEX_MAP = [
        'internal_representation.simple' => 'external_representation.simple',
        'internal_representation.flag' => [
            'external_representation.nested.flag' => 'importFlagCallback',
        ],
        'internal_representation.list.odd' => [
            'external_representation.list.both' => 'importOddCallback',
        ],
        'internal_representation.list.even' => [
            'external_representation.list.both' => 'importEvenCallback',
        ],
    ];
    const MARKER = '::exportFlag';

    private function exportFlagCallback($value)
    {
        return $value . self::MARKER;
    }

    private function importFlagCallback($value)
    {
        return str_replace(self::MARKER, '', $value);
    }

    private function exportListCallback(array $values)
    {
        $return = array_combine($values, $values);
        return $return;
    }

    private function importOddCallback(array $values)
    {
        $return = array_filter($values, function ($value) {
            if ($value % 2 === 1) {
                return true;
            }

            return false;
        });

        return $return;
    }

    private function importEvenCallback(array $values)
    {
        $return = array_filter($values, function ($value) {
            if ($value % 2 !== 1) {
                return true;
            }

            return false;
        });

        return $return;
    }
}
