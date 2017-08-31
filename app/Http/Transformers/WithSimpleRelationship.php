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
     * @param bool  $export
     * @param array $initialState
     * @return array
     */
    public function simpleMapping(array $data, $export, array $initialState = []) {
        $mapped = [];

        if (count($initialState)) {
            $mapped = $initialState;
        }

        foreach (self::SIMPLE_MAP as $dotted => $dashed) {
            if (is_numeric($dotted)) {
                $dotted = $dashed;
                $dashed = str_replace('.', '_', $dotted);
            }

            $source = $dotted;
            $destination = $dashed;

            if ($export) {
                $source = $dashed;
                $destination = $dotted;
            }

            $value = Arr::get($data, $source, '');

            if (is_null($value)) {
                $value = '';
            }

            Arr::set($mapped, $destination, $value);
        }

        return $mapped;
    }
}
