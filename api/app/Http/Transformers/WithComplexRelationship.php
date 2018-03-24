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
     * @param bool  $fromModelToResponse
     * @param array $mapped
     * @return array
     */
    public function complexMapping(array $data, $fromModelToResponse, array $mapped = []) {
        $map = $this->mapFromResponseToModel();

        if ($fromModelToResponse) {
            $map = $this->mapFromModelToResponse();
        }

        foreach ($map as $sendTo => $readFrom) {
            $value = $this->applyTransformations($data, $readFrom);
            Arr::set($mapped, $sendTo, $value);
        }

        return $mapped;
    }

    /**
     * Merge arrays in array_merge_recursive fashion. Doesn't append nested elements to arrays, it overwrites them
     * if the index is already defined.
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

    /**
     * @return array
     */
    private function mapFromResponseToModel()
    {
        return self::INVERSE_COMPLEX_MAP;
    }

    /**
     * @return array
     */
    private function mapFromModelToResponse()
    {
        return self::COMPLEX_MAP;
    }

    /**
     * Read the map, and apply the helper functions over the given array indexes
     *
     * @param array $data
     * @param array|string $readFrom
     * @return array|string|mixed
     */
    private function applyTransformations(array $data, $readFrom) {
        if (!is_array($readFrom)) {
            return Arr::get($data, $readFrom);
        }

        $buffer = [];

        foreach ($readFrom as $readFromIndex => $helperCallback) {
            $buffer[] = $this->applyTransformation($data, $readFromIndex, [$this, $helperCallback]);
        }

        if (!count($buffer)) {
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
     * @param array    $data
     * @param string   $readFromIndex
     * @param callable $helperCallback
     * @return mixed
     */
    private function applyTransformation(array $data, $readFromIndex, callable $helperCallback) {
        $argument = Arr::get($data, $readFromIndex);
        $value = call_user_func($helperCallback, $argument);
        return $value;
    }
}
