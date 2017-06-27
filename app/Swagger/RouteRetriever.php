<?php

namespace DentalSleepSolutions\Swagger;

class RouteRetriever
{
    const ROUTING_FILE = __DIR__ . '/../Http/routes.php';

    public function retrieveRoutes($controllerName, $routingFile = self::ROUTING_FILE)
    {
        $fileContents = file_get_contents($routingFile);

    }
}
