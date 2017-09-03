<?php
namespace DentalSleepSolutions\Http\Transformers;

use Illuminate\Support\Arr;

/**
 * Allow Transformers to define a dot notation map to transform input arrays, direct relationship.
 *
 * Class WithSimpleRelationship
 */
trait WithSimpleRelationship
{
    /**
     * Read source and target indexes to read, and set, values from one array to another.
     * Numeric indexes indicate translation from dot notation (field.nested) to snake case (field_nested).
     *
     * @param array $data
     * @param bool  $fromModelToResponse
     * @param array $mapped
     * @return array
     */
    public function simpleMapping(array $data, $fromModelToResponse, array $mapped = []) {
        foreach (self::SIMPLE_MAP as $requestElement => $modelProperty) {
            $readFrom = $requestElement;
            $sendTo = $modelProperty;

            if ($fromModelToResponse) {
                $readFrom = $modelProperty;
                $sendTo = $requestElement;
            }

            $value = Arr::get($data, $readFrom, '');

            if (is_null($value)) {
                $value = '';
            }

            Arr::set($mapped, $sendTo, $value);
        }

        return $mapped;
    }
}
