<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Services\ClassRetriever;
use PHPUnit\Framework\TestCase;
use Tests\Dummies\Eloquent\FirstDummy as FirstDummyModel;
use Tests\Dummies\Http\Controllers\FirstDummiesController;
use Tests\Dummies\Http\Requests\FirstDummy as FirstDummyRequest;

class ClassRetrieverTest extends TestCase
{
    const CONTROLLER_CLASS = FirstDummiesController::class;
    const HTTP_DIR = __DIR__ . '/../../Dummies/Http';

    /** @var ClassRetriever */
    private $classRetriever;

    public function setUp()
    {
        $this->classRetriever = new ClassRetriever();
    }

    public function testGetRequestClass()
    {
        $requestClass = $this->classRetriever->getRequestClass(self::CONTROLLER_CLASS, self::HTTP_DIR);
        $this->assertEquals(FirstDummyRequest::class, $requestClass);
    }

    public function testGetModelClass()
    {
        $modelClass = $this->classRetriever->getModelClass(self::CONTROLLER_CLASS);
        $this->assertEquals(FirstDummyModel::class, $modelClass);
    }
}
