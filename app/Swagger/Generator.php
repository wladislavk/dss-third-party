<?php

namespace DentalSleepSolutions\Swagger;

use DentalSleepSolutions\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Http\Controllers\BaseRestController;
use DentalSleepSolutions\NamingConventions\BindingNamingConvention;
use Illuminate\Filesystem\FilesystemAdapter;

class Generator
{
    const HTTP_DIR = __DIR__ . '/../Http';
    const CONTROLLER_DIR = '/Controllers';
    const MODEL_DIR = __DIR__ . '/../Eloquent';
    const BASE_CONTROLLER = 'BaseRestController';
    const COMMON_EXTENSION = '.php';
    const PSR4 = [
        'app' => 'DentalSleepSolutions',
        'tests' => 'Tests',
    ];

    /** @var ControllerAnnotationWriter */
    private $controllerAnnotationWriter;

    /** @var ModelAnnotationWriter */
    private $modelAnnotationWriter;

    /** @var BindingNamingConvention */
    private $namingConvention;

    /** @var FilesystemAdapter */
    private $filesystemAdapter;

    public function __construct(
        ControllerAnnotationWriter $controllerAnnotationWriter,
        ModelAnnotationWriter $modelAnnotationWriter,
        BindingNamingConvention $namingConvention,
        FilesystemAdapter $filesystemAdapter
    ) {
        $this->controllerAnnotationWriter = $controllerAnnotationWriter;
        $this->modelAnnotationWriter = $modelAnnotationWriter;
        $this->namingConvention = $namingConvention;
        $this->filesystemAdapter = $filesystemAdapter;
    }

    /**
     * @param string $httpDir
     * @param string $modelDir
     */
    public function generateSwagger($httpDir = self::HTTP_DIR, $modelDir = self::MODEL_DIR)
    {
        $restControllers = $this->getRestControllers($httpDir);
        foreach ($restControllers as $controllerFilename) {
            $requestClass = $this->getRequestClass($controllerFilename, $httpDir);
            $this->controllerAnnotationWriter->writeAnnotations($controllerFilename, $requestClass);
        }
        $models = $this->getModels($modelDir);
        foreach ($models as $modelFilename) {
            $this->modelAnnotationWriter->writeAnnotations($modelFilename);
        }
    }

    /**
     * @param string $httpDir
     * @return string[]
     */
    private function getRestControllers($httpDir)
    {
        $restControllers = [];
        $controllerFiles = $this->filesystemAdapter->allFiles($httpDir . self::CONTROLLER_DIR);
        foreach ($controllerFiles as $filename) {
            $contents = file_get_contents($filename);
            if (strstr($contents, ' extends ' . self::BASE_CONTROLLER)) {
                $restControllers[] = $filename;
            }
        }
        return $restControllers;
    }

    private function getModels($modelDir)
    {
        return $this->filesystemAdapter->allFiles($modelDir);
    }

    /**
     * @param string $controllerFilename
     * @param string $httpDir
     * @return string
     * @throws SwaggerGeneratorException
     */
    private function getRequestClass($controllerFilename, $httpDir)
    {
        $controllerClassName = $this->getControllerClassName($controllerFilename);
        $namingConvention = new BindingNamingConvention();
        $namingConvention->setController($controllerClassName);
        $namespace = $this->pathToNamespace($httpDir);
        $requestClass = $namingConvention->getRequest($namespace);
        return $requestClass;
    }

    /**
     * @param string $controllerFilename
     * @return string
     * @throws SwaggerGeneratorException
     */
    private function getControllerClassName($controllerFilename)
    {
        $contents = file_get_contents($controllerFilename);
        preg_match('/namespace\s(.+?);/', $contents, $namespaceMatches);
        preg_match('class\s(.+?)[\s\n]', $contents, $classNameMatches);
        if (!isset($namespaceMatches[1]) || !isset($classNameMatches[1])) {
            throw new SwaggerGeneratorException('Namespace or class not found in ' . $controllerFilename);
        }
        return $namespaceMatches[1] . '\\' . $classNameMatches[1];
    }

    private function pathToNamespace($path)
    {
        $realPath = realpath($path);
        $pathFromRoot = $realPath;
        foreach (self::PSR4 as $dir => $namespace) {
            $position = strpos($realPath, "/$dir/");
            if ($position !== false) {
                $pathFromRoot = substr($realPath, $position + 1);
                $pathFromRoot = str_replace($dir, $namespace, $pathFromRoot);
                break;
            }
        }
        return str_replace('/', '\\', $pathFromRoot);
    }
}
