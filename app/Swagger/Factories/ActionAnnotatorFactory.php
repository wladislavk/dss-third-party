<?php

namespace DentalSleepSolutions\Swagger\Factories;

use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\ActionAnnotators\AbstractActionAnnotator;
use DentalSleepSolutions\Swagger\ActionAnnotators\DestroyAnnotator;
use DentalSleepSolutions\Swagger\ActionAnnotators\IndexAnnotator;
use DentalSleepSolutions\Swagger\ActionAnnotators\ShowAnnotator;
use DentalSleepSolutions\Swagger\ActionAnnotators\StoreAnnotator;
use DentalSleepSolutions\Swagger\ActionAnnotators\UpdateAnnotator;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;

class ActionAnnotatorFactory
{
    const ANNOTATOR_CLASSES = [
        'index' => IndexAnnotator::class,
        'show' => ShowAnnotator::class,
        'store' => StoreAnnotator::class,
        'update' => UpdateAnnotator::class,
        'destroy' => DestroyAnnotator::class,
    ];

    /** @var Application */
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @param string $action
     * @return AbstractActionAnnotator
     * @throws SwaggerGeneratorException
     */
    public function findAnnotator($action)
    {
        if (!array_key_exists($action, self::ANNOTATOR_CLASSES)) {
            throw new SwaggerGeneratorException("Action $action is not valid");
        }
        $class = self::ANNOTATOR_CLASSES[$action];
        $object = $this->application->make($class);
        if (!$object instanceof AbstractActionAnnotator) {
            throw new SwaggerGeneratorException("Class $class must implement " . AbstractActionAnnotator::class);
        }
        return $object;
    }
}
