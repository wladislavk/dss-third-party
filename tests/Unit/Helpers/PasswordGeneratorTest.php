<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\PasswordGenerator;
use DentalSleepSolutions\Structs\NewPatientFormData;
use Tests\TestCases\UnitTestCase;

class PasswordGeneratorTest extends UnitTestCase
{
    /** @var PasswordGenerator */
    private $passwordGenerator;

    public function setUp()
    {
        $this->passwordGenerator = new PasswordGenerator();
    }

    public function testGeneratePassword()
    {
        $ssn = 1234321;
        $formData = new NewPatientFormData();
        $this->passwordGenerator->generatePassword($ssn, $formData);
        $this->assertEquals(12, strlen($formData->salt));
        $this->assertEquals(64, strlen($formData->password));
    }
}
