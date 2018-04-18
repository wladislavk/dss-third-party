<?php

namespace DentalSleepSolutions\Services;

use DentalSleepSolutions\NamingConventions\BindingNamingConvention;
use DentalSleepSolutions\Swagger\ClassRetrieverInterface;

class ClassRetriever implements ClassRetrieverInterface
{
    const PSR4 = [
        'app' => 'DentalSleepSolutions',
        'tests' => 'Tests',
    ];

    /**
     * @param string $controllerClassName
     * @param string $httpDir
     * @return string
     */
    public function getRequestClass($controllerClassName, $httpDir)
    {
        $namingConvention = new BindingNamingConvention();
        $namingConvention->setController($controllerClassName);
        $namespace = $this->getPathToNamespace($httpDir);
        $requestClass = $namingConvention->getRequest($namespace);
        return $requestClass;
    }

    /**
     * @param string $controllerClassName
     * @return string
     */
    public function getModelClass($controllerClassName)
    {
        $namingConvention = new BindingNamingConvention();
        $namingConvention->setController($controllerClassName);
        $modelClass = $namingConvention->getModel();
        return $modelClass;
    }

    /**
     * @param string $path
     * @return string
     */
    private function getPathToNamespace($path)
    {
        $realPath = realpath($path);
        foreach (self::PSR4 as $dir => $namespace) {
            $realPath = $this->changePath($realPath, $dir, $namespace);
        }
        return str_replace('/', '\\', $realPath);
    }

    /**
     * @param string $realPath
     * @param string $dir
     * @param string $namespace
     * @return string
     */
    private function changePath($realPath, $dir, $namespace)
    {
        $position = strpos($realPath, "/$dir/");
        if ($position === false) {
            return $realPath;
        }
        $pathFromRoot = substr($realPath, $position + 1);
        return str_replace($dir, $namespace, $pathFromRoot);
    }
}
