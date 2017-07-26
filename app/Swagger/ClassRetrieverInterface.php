<?php

namespace DentalSleepSolutions\Swagger;

interface ClassRetrieverInterface
{
    /**
     * @param string $controllerClassName
     * @param string $httpDir
     * @return string
     */
    public function getRequestClass($controllerClassName, $httpDir);

    /**
     * @param string $controllerClassName
     * @return string
     */
    public function getModelClass($controllerClassName);
}
