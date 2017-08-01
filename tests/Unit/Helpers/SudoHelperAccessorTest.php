<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\SudoHelperAccessor;
use DentalSleepSolutions\StaticClasses\SudoHelper;
use DentalSleepSolutions\Structs\SudoId;
use Tests\TestCases\UnitTestCase;

class SudoHelperAccessorTest extends UnitTestCase
{
    const USER_ID = SudoHelper::USER_PREFIX . '1';
    const ADMIN_ID = SudoHelper::ADMIN_PREFIX . '1';
    const SUDO_ID = self::ADMIN_ID . SudoHelper::LOGIN_ID_DELIMITER . self::USER_ID;

    /** @var SudoHelperAccessor */
    private $accessor;

    public function setUp()
    {
        $this->accessor = new SudoHelperAccessor();
    }

    public function testIsSimpleId()
    {
        $result = $this->accessor->isSimpleId(self::USER_ID);
        $this->assertTrue($result);
    }

    public function testIsNotSimpleId()
    {
        $result = $this->accessor->isSimpleId(self::SUDO_ID);
        $this->assertFalse($result);
    }

    public function testIsSudoId()
    {
        $result = $this->accessor->isSudoId(self::SUDO_ID);
        $this->assertTrue($result);
    }

    public function testIsNotSudoId()
    {
        $result = $this->accessor->isSudoId(self::USER_ID);
        $this->assertFalse($result);
    }

    public function testSudoId()
    {
        $result = $this->accessor->sudoId(self::ADMIN_ID, self::USER_ID);
        $this->assertEquals(self::SUDO_ID, $result);
    }

    public function testParseId()
    {
        $result = $this->accessor->parseId(self::SUDO_ID);

        $this->assertInstanceOf(SudoId::class, $result);
        $this->assertEquals(self::SUDO_ID, $result->id);
        $this->assertEquals(self::ADMIN_ID, $result->adminId);
        $this->assertEquals(self::USER_ID, $result->userId);
    }

    public function testParseInvalidId()
    {
        $result = $this->accessor->parseId(self::USER_ID);

        $this->assertInstanceOf(SudoId::class, $result);
        $this->assertEquals(self::USER_ID, $result->id);
        $this->assertEquals('', $result->adminId);
        $this->assertEquals('', $result->userId);
    }
}
