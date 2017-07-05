<?php

namespace DentalSleepSolutions\Swagger;

use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\AnnotationComposers\ControllerComposer;
use DentalSleepSolutions\Swagger\AnnotationComposers\ModelComposer;
use DentalSleepSolutions\Swagger\Structs\AnnotationParams;
use DentalSleepSolutions\Swagger\Wrappers\FilesystemWrapper;

class Generator
{
    const HTTP_DIR = __DIR__ . '/../Http';
    const CONTROLLER_DIR = '/Controllers';
    const MODEL_DIR = __DIR__ . '/../Eloquent';
    const BASE_CONTROLLER = 'BaseRestController';

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
     */
    public function generateSwagger($httpDir = self::HTTP_DIR, $modelDir = self::MODEL_DIR)
    {
        $models = $this->getModels($modelDir);
        $annotationGroups = [];
        foreach ($models as $modelFilename) {
            $annotationParams = new AnnotationParams();
            $annotationParams->modelClassName = $this->getClassName($modelFilename);
            $annotationGroups[$modelFilename] = $this->modelComposer->composeAnnotation($annotationParams);
        }
        $restControllers = $this->getRestControllers($httpDir);
        foreach ($restControllers as $controllerFilename) {
            $controllerClassName = $this->getClassName($controllerFilename);
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
        $modelFiles = $this->filesystemWrapper->allFiles($modelDir);
        $goodFiles = [];
        foreach ($modelFiles as $modelFile) {
            if (!strstr($modelFile, 'Abstract')) {
                $goodFiles[] = $modelFile;
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
        preg_match('/namespace\s(.+?);/', $contents, $namespaceMatches);
        preg_match('/class\s(.+?)[\s\n]/', $contents, $classNameMatches);
        if (!isset($namespaceMatches[1]) || !isset($classNameMatches[1])) {
            throw new SwaggerGeneratorException('Namespace or class not found in ' . $filename);
        }
        return $namespaceMatches[1] . '\\' . $classNameMatches[1];
    }
}
