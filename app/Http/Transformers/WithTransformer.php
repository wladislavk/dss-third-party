<?php
namespace DentalSleepSolutions\Http\Transformers;

trait WithTransformer
{
    /**
     * @param array $data
     * @return array+
     */
    public function inverseTransform(array $data) {
        return $data;
    }
}
