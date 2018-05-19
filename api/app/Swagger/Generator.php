<?php

namespace DentalSleepSolutions\Swagger;

use DentalSleepSolutions\Http\Controllers\BaseRestController;
use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\AnnotationComposers\ControllerComposer;
use DentalSleepSolutions\Swagger\AnnotationComposers\ModelComposer;
use DentalSleepSolutions\Swagger\StaticClasses\ClassMetadataRetriever;
use DentalSleepSolutions\Swagger\StaticClasses\ParentRetriever;
use DentalSleepSolutions\Swagger\Structs\AnnotationParams;
use DentalSleepSolutions\Swagger\Wrappers\FilesystemWrapper;

class Generator
{
    const HTTP_DIR = __DIR__ . '/../Http';
    const CONTROLLER_DIR = '/Controllers';
    const MODEL_DIR = __DIR__ . '/../Eloquent/Models';
    const BASE_CONTROLLER = BaseRestController::class;

    /** @var AnnotationWriter */
    private $annotationWriter;

    /** @var ControllerComposer */
    private $controllerComposer;

    /** @var ModelComposer */
    private $modelComposer;

    /** @var ClassRetrieverInterface */
    private $classRetriever;

    /** @var FilesystemWrapper */
    private $filesystemWrapper;

    public function __construct(
        AnnotationWriter $annotationWriter,
        ControllerComposer $controllerComposer,
        ModelComposer $modelComposer,
        ClassRetrieverInterface $classRetriever,
        FilesystemWrapper $filesystemWrapper
    ) {
        $this->annotationWriter = $annotationWriter;
        $this->controllerComposer = $controllerComposer;
        $this->modelComposer = $modelComposer;
        $this->classRetriever = $classRetriever;
        $this->filesystemWrapper = $filesystemWrapper;
    }

    /**
     * @param string $httpDir
     * @param string $modelDir
     * @throws SwaggerGeneratorException
     * @throws \ReflectionException
     */
    public function generateSwagger($httpDir = self::HTTP_DIR, $modelDir = self::MODEL_DIR)
    {
        $models = $this->getModels($modelDir);
        $annotationGroups = [];
        foreach ($models as $modelClassName => $modelFilename) {
            $annotationParams = new AnnotationParams();
            $annotationParams->modelClassName = $modelClassName;
            $annotationGroups[$modelFilename] = $this->modelComposer->composeAnnotation($annotationParams);
        }
        $restControllers = $this->getRestControllers($httpDir);
        foreach ($restControllers as $controllerClassName => $controllerFilename) {
            $annotationParams = new AnnotationParams();
            $annotationParams->controllerClassName = $controllerClassName;
            $annotationParams->requestClassName = $this->classRetriever
                ->getRequestClass($controllerClassName, $httpDir);
            $annotationParams->modelClassName = $this->classRetriever->getModelClass($controllerClassName);
            $annotationGroups[$controllerFilename] = $this->controllerComposer
                ->composeAnnotation($annotationParams);
        }
        foreach ($annotationGroups as $filename => $annotations) {
            $this->annotationWriter->writeAnnotations($filename, $annotations);
        }
    }

    /**
     * @param string $httpDir
     * @return string[]
     * @throws SwaggerGeneratorException
     */
    private function getRestControllers($httpDir)
    {
        $restControllers = [];
        $controllerFiles = $this->filesystemWrapper->allFiles($httpDir . self::CONTROLLER_DIR);
        foreach ($controllerFiles as $filename) {
            $className = $this->getClassName($filename);
            $parents = ParentRetriever::getParents($className);
            if (in_array(self::BASE_CONTROLLER, $parents)) {
                $restControllers[$className] = $filename;
            }
        }
        return $restControllers;
    }

    /**
     * @param string $modelDir
     * @return array
     * @throws SwaggerGeneratorException
     * @throws \ReflectionException
     */
    private function getModels($modelDir)
    {
        $modelFiles = $this->filesystemWrapper->allFiles($modelDir);
        $goodFiles = [];
        foreach ($modelFiles as $modelFile) {
            $className = $this->getClassName($modelFile);
            $reflection = new \ReflectionClass($className);
            if (!$reflection->isAbstract()) {
                $goodFiles[$className] = $modelFile;
            }
        }
        return $goodFiles;
    }

    /**
     * @param string $filename
     * @return string
     * @throws SwaggerGeneratorException
     */
    private function getClassName($filename)
    {
        $contents = $this->filesystemWrapper->fileGetContents($filename);
        $className = ClassMetadataRetriever::getClassNameFromFile($contents);
        if (!$className) {
            throw new SwaggerGeneratorException('Namespace or class not found in ' . $filename);
        }
        return $className;
    }
}
