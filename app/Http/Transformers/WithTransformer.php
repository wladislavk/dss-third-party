<?php
namespace DentalSleepSolutions\Http\Transformers;

trait WithTransformer
{
    /**
     * @param array $data
     * @return array+
     */
    public function fromTransform(array $data) {
        return $data;
    }
}
