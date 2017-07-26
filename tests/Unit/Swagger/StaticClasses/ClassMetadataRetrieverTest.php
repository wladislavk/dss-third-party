<?php

namespace Tests\Unit\Swagger\StaticClasses;

use DentalSleepSolutions\Swagger\StaticClasses\ClassMetadataRetriever;
use Tests\TestCases\UnitTestCase;

class ClassMetadataRetrieverTest extends UnitTestCase
{
    public function testGetClassName()
    {
        $contents = <<<FILE
<?php

namespace Foo\Bar;

class Baz
{
}
FILE;
        $className = ClassMetadataRetriever::getClassNameFromFile($contents);
        $this->assertEquals('Foo\\Bar\\Baz', $className);
    }

    public function testWithoutClassName()
    {
        $contents = <<<FILE
<?php

namespace Foo\Bar;

\$baz = 1;
FILE;
        $className = ClassMetadataRetriever::getClassNameFromFile($contents);
        $this->assertEquals('', $className);
    }

    public function testWithoutNamespace()
    {
        $contents = <<<FILE
<?php

class Baz
{
}
FILE;
        $className = ClassMetadataRetriever::getClassNameFromFile($contents);
        $this->assertEquals('\\Baz', $className);
    }
}
