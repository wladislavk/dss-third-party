<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\SudoHelper;
use DentalSleepSolutions\Structs\SudoId;
use Tests\TestCases\UnitTestCase;

class SudoHelperTest extends UnitTestCase
{
    const USER_ID = SudoHelper::USER_PREFIX . '1';
    const ADMIN_ID = SudoHelper::ADMIN_PREFIX . '1';
    const SUDO_ID = self::ADMIN_ID . SudoHelper::LOGIN_ID_DELIMITER . self::USER_ID;

    /** @var SudoHelper */
    private $sudo;

    public function setUp()
    {
        $this->sudo = new SudoHelper();
    }

    public function testIsSimpleId()
    {
        $result = $this->sudo->isSimpleId(self::USER_ID);
        $this->assertTrue($result);
    }

    public function testIsNotSimpleId()
    {
        $result = $this->sudo->isSimpleId(self::SUDO_ID);
        $this->assertFalse($result);
    }

    public function testIsSudoId()
    {
        $result = $this->sudo->isSudoId(self::SUDO_ID);
        $this->assertTrue($result);
    }

    public function testIsNotSudoId()
    {
        $result = $this->sudo->isSudoId(self::USER_ID);
        $this->assertFalse($result);
    }

    public function testSudoId()
    {
        $result = $this->sudo->sudoId(self::ADMIN_ID, self::USER_ID);
        $this->assertEquals(self::SUDO_ID, $result);
    }

    public function testParseId()
    {
        $result = $this->sudo->parseId(self::SUDO_ID);

        $this->assertInstanceOf(SudoId::class, $result);
        $this->assertEquals(self::SUDO_ID, $result->id);
        $this->assertEquals(self::ADMIN_ID, $result->adminId);
        $this->assertEquals(self::USER_ID, $result->userId);
    }

    public function testParseInvalidId()
    {
        $result = $this->sudo->parseId(self::USER_ID);

        $this->assertInstanceOf(SudoId::class, $result);
        $this->assertEquals(self::USER_ID, $result->id);
        $this->assertEquals('', $result->adminId);
        $this->assertEquals('', $result->userId);
    }
}
