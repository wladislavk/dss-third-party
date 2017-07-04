<?php

namespace DentalSleepSolutions\Swagger;

use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\Factories\ModelTransformerFactory;
use DentalSleepSolutions\Swagger\Factories\RuleTransformerFactory;
use DentalSleepSolutions\NamingConventions\BindingNamingConvention;
use DentalSleepSolutions\Swagger\AnnotationTypes\ControllerType;
use DentalSleepSolutions\Swagger\AnnotationTypes\ModelType;
use DentalSleepSolutions\Swagger\Structs\AnnotationParams;
use DentalSleepSolutions\Swagger\Wrappers\FilesystemWrapper;
use Illuminate\Filesystem\FilesystemAdapter;

class Generator
{
    const HTTP_DIR = __DIR__ . '/../Http';
    const CONTROLLER_DIR = '/Controllers';
    const MODEL_DIR = __DIR__ . '/../Eloquent';
    const BASE_CONTROLLER = 'BaseRestController';
    const PSR4 = [
        'app' => 'DentalSleepSolutions',
        'tests' => 'Tests',
    ];

    /** @var AnnotationWriter */
    private $annotationWriter;

    /** @var ControllerType */
    private $controllerType;

    /** @var ModelType */
    private $modelType;

    /** @var FilesystemWrapper */
    private $filesystemWrapper;

    public function __construct(
        AnnotationWriter $annotationWriter,
        ControllerType $controllerType,
        ModelType $modelType,
        ModelTransformerFactory $modelTransformerFactory,
        RuleTransformerFactory $ruleTransformerFactory,
        FilesystemWrapper $filesystemWrapper
    )
    {
        $this->annotationWriter = $annotationWriter;
        $this->controllerType = $controllerType;
        $this->controllerType->setTransformerFactory($ruleTransformerFactory);
        $this->modelType = $modelType;
        $this->modelType->setTransformerFactory($modelTransformerFactory);
        $this->filesystemWrapper = $filesystemWrapper;
    }

    /**
     * @param string $httpDir
     * @param string $modelDir
     */
    public function generateSwagger($httpDir = self::HTTP_DIR, $modelDir = self::MODEL_DIR)
    {
        $models = $this->getModels($modelDir);
        $annotationGroups = [];
        foreach ($models as $modelFilename) {
            $modelClassName = $this->getClassName($modelFilename);
            $annotationGroups[$modelFilename] = $this->modelType->composeAnnotation($modelClassName);
        }
        $restControllers = $this->getRestControllers($httpDir);
        foreach ($restControllers as $controllerFilename) {
            $controllerClassName = $this->getClassName($controllerFilename);
            $annotationParams = new AnnotationParams();
            $annotationParams->requestClassName = $this->getRequestClass($controllerClassName, $httpDir);
            $annotationParams->modelClassName = $this->getModelClass($controllerClassName, $httpDir);
            $annotationGroups[$controllerFilename] = $this->controllerType
                ->composeAnnotation($controllerClassName, $annotationParams);
        }
        foreach ($annotationGroups as $filename => $annotations) {
            $this->annotationWriter->writeAnnotations($filename, $annotations);
        }
    }

    /**
     * @param string $httpDir
     * @return string[]
     */
    private function getRestControllers($httpDir)
    {
        $restControllers = [];
        $controllerFiles = $this->filesystemWrapper->allFiles($httpDir . self::CONTROLLER_DIR);
        foreach ($controllerFiles as $filename) {
            $contents = $this->filesystemWrapper->fileGetContents($filename);
            if (strstr($contents, ' extends ' . self::BASE_CONTROLLER)) {
                $restControllers[] = $filename;
            }
        }
        return $restControllers;
    }

    /**
     * @param string $modelDir
     * @return array
     */
    private function getModels($modelDir)
    {
        return $this->filesystemWrapper->allFiles($modelDir);
    }

    /**
     * @param string $controllerClassName
     * @param string $httpDir
     * @return string
     * @throws SwaggerGeneratorException
     */
    private function getRequestClass($controllerClassName, $httpDir)
    {
        $namingConvention = new BindingNamingConvention();
        $namingConvention->setController($controllerClassName);
        $namespace = $this->pathToNamespace($httpDir);
        $requestClass = $namingConvention->getRequest($namespace);
        return $requestClass;
    }

    /**
     * @param string $controllerClassName
     * @param string $httpDir
     * @return string
     */
    private function getModelClass($controllerClassName, $httpDir)
    {
        $namingConvention = new BindingNamingConvention();
        $namingConvention->setController($controllerClassName);
        $modelClass = $namingConvention->getModel();
        return $modelClass;
    }

    /**
     * @param string $filename
     * @return string
     * @throws SwaggerGeneratorException
     */
    private function getClassName($filename)
    {
        $contents = $this->filesystemWrapper->fileGetContents($filename);
        preg_match('/namespace\s(.+?);/', $contents, $namespaceMatches);
        preg_match('/class\s(.+?)[\s\n]/', $contents, $classNameMatches);
        if (!isset($namespaceMatches[1]) || !isset($classNameMatches[1])) {
            throw new SwaggerGeneratorException('Namespace or class not found in ' . $filename);
        }
        return $namespaceMatches[1] . '\\' . $classNameMatches[1];
    }

    /**
     * @param string $path
     * @return string
     */
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
