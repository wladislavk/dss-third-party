<?php

namespace DentalSleepSolutions\Swagger\AnnotationComposers;

use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\Factories\ActionAnnotatorFactory;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Swagger\Factories\RuleTransformerFactory;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use DentalSleepSolutions\Swagger\Structs\AnnotationParams;
use DentalSleepSolutions\Swagger\Structs\AnnotationRule;
use DentalSleepSolutions\Swagger\Wrappers\DocBlockRetriever;
use DentalSleepSolutions\Swagger\RoutePathRetriever;

class ControllerComposer extends AbstractAnnotationComposer
{
    const REST_ACTIONS = [
        'index',
        'show',
        'store',
        'update',
        'destroy',
    ];

    /** @var ActionAnnotatorFactory */
    private $annotatorFactory;

    /** @var RoutePathRetriever */
    private $routePathRetriever;

    public function __construct(
        RuleTransformerFactory $ruleTransformerFactory,
        DocBlockRetriever $docBlockRetriever,
        ActionAnnotatorFactory $annotatorFactory,
        RoutePathRetriever $routePathRetriever
    ) {
        parent::__construct($ruleTransformerFactory, $docBlockRetriever);
        $this->annotatorFactory = $annotatorFactory;
        $this->routePathRetriever = $routePathRetriever;
    }

    /**
     * @param AnnotationParams $annotationParams
     * @return AnnotationData[]
     * @throws SwaggerGeneratorException
     */
    protected function getAnnotationData(AnnotationParams $annotationParams)
    {
        $annotations = [];
        foreach (self::REST_ACTIONS as $action) {
            $annotationData = new AnnotationData();
            $annotationData->action = $action;
            $annotationData->docBlock = $this->docBlockRetriever
                ->getFromFunction($annotationParams->controllerClassName, $action);
            $annotationData->route = $this->routePathRetriever
                ->getRoutePath($annotationParams->controllerClassName, $action);
            $annotationData->params = $annotationParams;
            $annotationData->shortModelClassName = $this
                ->getShortModelClass($annotationParams->modelClassName);
            $annotationData->operator = "public function $action(";
            $annotations[] = $annotationData;
        }
        return $annotations;
    }

    /**
     * @param AnnotationData $annotationData
     * @return string
     * @throws SwaggerGeneratorException
     */
    protected function createAnnotation(AnnotationData $annotationData)
    {
        $annotator = $this->annotatorFactory->findAnnotator($annotationData->action);
        $annotation = $annotator->createAnnotation($annotationData);
        return $annotation;
    }

    /**
     * @param AnnotationData $annotationData
     */
    protected function setRules(AnnotationData $annotationData)
    {
        /** @var Request $request */
        $request = new $annotationData->params->requestClassName();
        $rules = $this->getRequestRules($request, $annotationData->action);
        foreach ($rules as $field => $rule) {
            $annotationRule = new AnnotationRule();
            $stringRule = $this->getStringRule($rule);
            $annotationRule->rule = $stringRule;
            $annotationRule->field = $field;
            $annotationData->addRule($annotationRule);
        }
    }

    /**
     * @param string|array $rule
     * @return string
     */
    private function getStringRule($rule)
    {
        if (is_array($rule)) {
            return join('|', $rule);
        }
        return $rule;
    }

    private function getRequestRules(Request $request, $action)
    {
        if ($action == 'store') {
            return $request->storeRules();
        }
        if ($action == 'update') {
            return $request->updateRules();
        }
        return [];
    }
}
