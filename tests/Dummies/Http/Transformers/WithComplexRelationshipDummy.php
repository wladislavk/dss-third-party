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
    const ELEMENT_DELIMITER = '~';
    const PAIR_DELIMITER = '|';
    const MARKER = '::exportFlag';

    private function exportFlagCallback($value)
    {
        return $value . self::MARKER;
    }

    private function importFlagCallback($value)
    {
        return str_replace(self::MARKER, '', $value);
    }

    private function exportListCallback($serializedValues)
    {
        $return = [];
        $values = explode(self::ELEMENT_DELIMITER, $serializedValues);

        foreach ($values as $each) {
            if (strpos($each, self::PAIR_DELIMITER) !== false) {
                list($key, $value) = explode(self::PAIR_DELIMITER, $each, 2);
                $return[$key] = $value;
            }
        }

        return $return;
    }

    private function importOddCallback(array $values)
    {
        return $this->importOddEvenCallback($values, true);
    }

    private function importEvenCallback(array $values)
    {
        return $this->importOddEvenCallback($values, false);
    }

    private function importOddEvenCallback(array $values, $oddOnly)
    {
        $return = [];

        foreach ($values as $key => $value) {
            if ((bool)($value & 1) === $oddOnly) {
                $return[] = $key . self::PAIR_DELIMITER . $value;
            }
        }

        $return = join(self::ELEMENT_DELIMITER, $return);
        return $return;
    }
}
