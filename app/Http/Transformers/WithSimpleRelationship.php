<?php
namespace DentalSleepSolutions\Http\Transformers;

/**
 * Allow Transformers to define a dot notation map to transform input arrays, direct relationship.
 *
 * Class WithSimpleRelationship
 * @package DentalSleepSolutions\Http\Transformers
 */
trait WithSimpleRelationship
{
    /**
     * Read source and target indexes to read, and set, values from one array to another.
     *
     * @param array $data
     * @param bool  $export
     * @param array $initialState
     * @return array
     */
    public function simpleMapping(array $data, $export, array $initialState=[]) {
        $mapped = $initialState ?: [];

        foreach (self::SIMPLE_MAP as $dotted=>$dashed) {
            if (is_numeric($dotted)) {
                $dotted = $dashed;
                $dashed = str_replace('.', '_', $dotted);
            }

            $source = $export ? $dashed : $dotted;
            $destination = $export ? $dotted : $dashed;

            $value = Arr::get($data, $source, '');
            $value = is_null($value) ? '' : $value;

            Arr::set($mapped, $destination, $value);
        }

        return $mapped;
    }
}
