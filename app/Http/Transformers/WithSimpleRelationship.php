<?php
namespace DentalSleepSolutions\Http\Transformers;

trait WithSimpleRelationship
{
    /**
     * @param array $data
     * @param bool  $export
     * @param array $initialState
     * @return array
     */
    public function simpleMapping (Array $data, $export, Array $initialState=[]) {
        $mapped = $initialState ?: [];

        foreach ($this->simpleMap as $dotted=>$dashed) {
            if (is_numeric($dotted)) {
                $dotted = $dashed;
                $dashed = str_replace('.', '_', $dotted);
            }

            $source = $export ? $dashed : $dotted;
            $destination = $export ? $dotted : $dashed;

            $value = array_get($data, $source, '');
            $value = is_null($value) ? '' : $value;

            array_set($mapped, $destination, $value);
        }

        return $mapped;
    }
}
