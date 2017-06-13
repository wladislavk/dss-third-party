<?php
namespace DentalSleepSolutions\Http\Transformers;

trait WithComplexRelationship
{
    /**
     * @param array $data
     * @param bool  $export
     * @param array $initialState
     * @return array
     */
    public function complexMapping (Array $data, $export, Array $initialState=[]) {
        $mapped = $initialState ?: [];
        $map = $export ? $this->complexMap : $this->inverseComplexMap;

        foreach ($map as $destination=>$source) {
            $value = null;

            if (is_array($source)) {
                $buffer = [];

                foreach ($source as $newSource=>$helper) {
                    if (!method_exists($this, $helper)) {
                        throw new \RuntimeException("[$helper]: Helper method not defined");
                    }

                    $buffer []= $this->{$helper}(array_get($data, $newSource));
                }

                if ($buffer) {
                    if (count($buffer) === 1) {
                        $value = $buffer[0];
                    } else {
                        // Merge each one of the resulting arrays
                        $value = $this->deepMerge($buffer);
                    }
                }
            } else {
                $value = array_get($data, $source);
            }

            array_set($mapped, $destination, $value);
        }

        return $mapped;
    }

    public function deepMerge (Array $array) {
        $map = array_dot($array);
        $merged = [];

        /**
         * $array is an array of arrays. The first index in the chain should then be ignored to treat
         * each element as part of the same array
         */
        foreach ($map as $path=>$value) {
            $destination = preg_replace('/^\d+\./', '', $path);
            array_set($merged, $destination, $value);
        }

        return $merged;
    }
}
