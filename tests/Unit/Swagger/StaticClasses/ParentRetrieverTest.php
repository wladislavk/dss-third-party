<?php

namespace Tests\Unit\Swagger\StaticClasses;

use DentalSleepSolutions\Swagger\StaticClasses\ParentRetriever;
use Tests\Dummies\Hierarchy\Bar;
use Tests\Dummies\Hierarchy\Baz;
use Tests\Dummies\Hierarchy\Foo;
use Tests\TestCases\UnitTestCase;

class ParentRetrieverTest extends UnitTestCase
{
    public function testWithoutParents()
    {
        $className = Foo::class;
        $parents = ParentRetriever::getParents($className);
        $this->assertEquals([], $parents);
    }

    public function testWithParent()
    {
        $className = Bar::class;
        $parents = ParentRetriever::getParents($className);
        $this->assertEquals([Foo::class], $parents);
    }

    public function testWithGrandparent()
    {
        $className = Baz::class;
        $parents = ParentRetriever::getParents($className);
        $this->assertEquals([Bar::class, Foo::class], $parents);
    }
}
