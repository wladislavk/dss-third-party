<?php

namespace TestCases;

use PHPUnit\Framework\TestCase;

class UnitTestCase extends TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }
}
