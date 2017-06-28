<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Swagger\TransformerInterface;
use Illuminate\Support\Facades\App;

abstract class AbstractSwaggerTransformerFactory
{
    /**
     * @param string $rule
     * @return TransformerInterface
     * @throws GeneralException
     */
    public function getTransformer($rule)
    {
        $className = $this->findRuleClass($rule);
        $transformer = App::make($className);
        if (!$transformer instanceof TransformerInterface) {
            throw new GeneralException("Class $className must implement " . TransformerInterface::class);
        }
        return $transformer;
    }

    /**
     * @param string $rule
     * @return string
     * @throws GeneralException
     */
    abstract protected function findRuleClass($rule);
}
