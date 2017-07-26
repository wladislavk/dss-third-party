<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\NameSetter;
use Tests\TestCases\UnitTestCase;

class NameSetterTest extends UnitTestCase
{
    /** @var NameSetter */
    private $nameSetter;

    public function setUp()
    {
        $this->nameSetter = new NameSetter();
    }

    public function testWithLabel()
    {
        $firstName = 'John';
        $middleName = 'Harry';
        $lastName = 'Doe';
        $label = 'Patient';
        $fullName = $this->nameSetter->formFullName($firstName, $middleName, $lastName, $label);
        $this->assertEquals('Doe, John Harry - Patient', $fullName);
    }

    public function testWithoutLabel()
    {
        $firstName = 'John';
        $middleName = 'Harry';
        $lastName = 'Doe';
        $fullName = $this->nameSetter->formFullName($firstName, $middleName, $lastName);
        $this->assertEquals('Doe, John Harry', $fullName);
    }
}
