<?php
namespace DentalSleepSolutions\Http\Transformers;

use Illuminate\Support\Arr;

/**
 * Allow Transformers to define a dot notation map to transform input arrays, applying helper methods to transform
 * the data.
 *
 * Class WithComplexRelationship
 */
trait WithComplexRelationship
{
    /**
     * Method to map, transform, and merge, data. The new fields are merged recursively into $initialState.
     *
     * @param array $data
     * @param bool  $export
     * @param array $initialState
     * @return array
     */
    public function complexMapping(array $data, $export, array $initialState = []) {
        $mapped = [];

        if (count($initialState)) {
            $mapped = $initialState;
        }

        $map = self::INVERSE_COMPLEX_MAP;

        if ($export) {
            $map = self::COMPLEX_MAP;
        }

        foreach ($map as $destination=>$source) {
            $value = $this->applyTransformations($data, $source);

            Arr::set($mapped, $destination, $value);
        }

        return $mapped;
    }

    /**
     * Read the map, and apply the helper functions over the given array indexes
     *
     * @param $data
     * @param $source
     * @return array|string|mixed
     */
    private function applyTransformations($data, $source) {
        if (!is_array($source)) {
            return Arr::get($data, $source);
        }

        $buffer = [];

        foreach ($source as $newSource=>$helper) {
            $this->applyTransformation($buffer, $data, $newSource, [$this, $helper]);
        }

        if (!$buffer) {
            return '';
        }

        if (count($buffer) === 1) {
            return array_shift($buffer);
        }

        return $this->deepMerge($buffer);
    }

    /**
     * Apply a method over the $data[$index] value, and append the return value to $buffer.
     *
     * @param array    $buffer
     * @param array    $data
     * @param string   $index
     * @param callable $helper
     */
    private function applyTransformation(array &$buffer, array $data, $index, callable $helper) {
        $argument = Arr::get($data, $index);
        $value = call_user_func($helper, $argument);
        array_push($buffer, $value);
    }

    /**
     * Set array values using dot notation. This makes easier to merge arrays.
     *
     * @param array $array
     * @return array
     */
    public function deepMerge(array $array) {
        $map = Arr::dot($array);
        $merged = [];

        /**
         * $array is an array of arrays. The first index in the chain should then be ignored to treat
         * each element as part of the same array
         */
        foreach ($map as $path => $value) {
            $destination = preg_replace('/^\d+\./', '', $path);
            Arr::set($merged, $destination, $value);
        }

        return $merged;
    }
}
