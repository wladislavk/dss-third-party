<?php

namespace DentalSleepSolutions\Swagger\Wrappers;

class DocBlockRetriever
{
    /**
     * @param string $className
     * @return string
     */
    public function getFromClass($className)
    {
        $reflector = new \ReflectionClass($className);
        $docBlock = '' . $reflector->getDocComment();
        return $docBlock;
    }

    /**
     * @param string $className
     * @param string $functionName
     * @return string
     */
    public function getFromFunction($className, $functionName)
    {
        $reflector = new \ReflectionClass($className);
        $docBlock = '' . $reflector->getMethod($functionName)->getDocComment();
        return $docBlock;
    }
}
