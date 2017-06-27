<?php

namespace Tests\Dummies\Controllers;

use DentalSleepSolutions\Http\Controllers\BaseRestController;

class DummiesController extends BaseRestController
{
    public function getModelNamespace()
    {
        return 'Tests\\Dummies\\Models';
    }
}
