<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Services\PasswordGenerator;
use DentalSleepSolutions\Structs\Password;
use DentalSleepSolutions\Wrappers\HashWrapper;
use Illuminate\Contracts\Hashing\Hasher;
use Tests\TestCases\UnitTestCase;

class PasswordGeneratorTest extends UnitTestCase
{
    const BASE_PASSWORD = 1234321;
    const BCRYPT_PASSWORD = 'deadbeef';
    const BCRYPT_SALT = 'abcdef1234567890abcdef';
    const BCRYPT_HASH = '$12$12$' . self::BCRYPT_SALT . self::BCRYPT_PASSWORD;
    const BCRYPT_SALT_LENGTH = 22;
    const LEGACY_HASH = 'd3adc0d3';
    const LEGACY_SALT_LENGTH = 12;
    const SHA1 = 'd0be2dc421be4fcd0172e5afceea3970e2f3d940';
    const BCRYPT_VERIFY = 'bcrypt';
    const LEGACY_VERIFY = 'legacy';

    /** @var PasswordGenerator */
    private $passwordGenerator;

    public function setUp()
    {
        $bcryptHasher = $this->mockBcryptHasher();
        $legacyHasher = $this->mockLegacyHasher();
        $this->passwordGenerator = new PasswordGenerator($bcryptHasher, $legacyHasher);
    }

    public function testGeneratePassword()
    {
        $passwordStruct = new Password();
        $this->passwordGenerator->generatePassword(self::BASE_PASSWORD, $passwordStruct);

        $this->assertEquals(self::BCRYPT_HASH, $passwordStruct->password);
        $this->assertEquals(self::BCRYPT_SALT, $passwordStruct->salt);
        $this->assertEquals(self::BCRYPT_SALT_LENGTH, strlen($passwordStruct->salt));
    }

    public function testGenerateLegacyPassword()
    {
        $passwordStruct = new Password();
        $this->passwordGenerator->generateLegacyPassword(self::BASE_PASSWORD, $passwordStruct);

        $this->assertEquals(self::LEGACY_HASH, $passwordStruct->password);
        $this->assertEquals(self::BCRYPT_SALT, $passwordStruct->salt);
        $this->assertEquals(self::BCRYPT_SALT_LENGTH, strlen($passwordStruct->salt));
    }

    public function testCreateSalt()
    {
        $salt = $this->passwordGenerator->createSalt();
        $this->assertEquals(self::BCRYPT_SALT, $salt);
        $this->assertEquals(self::BCRYPT_SALT_LENGTH, strlen($salt));
    }

    public function testCreateLegacySalt()
    {
        $salt = $this->passwordGenerator->createLegacySalt();
        $this->assertEquals(self::LEGACY_SALT_LENGTH, strlen($salt));
    }

    public function testHash()
    {
        $password = $this->passwordGenerator->hash(self::BASE_PASSWORD, self::BCRYPT_SALT);
        $this->assertEquals(self::LEGACY_HASH, $password);
    }

    public function testVerifyBcrypt()
    {
        $result = $this->passwordGenerator->verify(self::BASE_PASSWORD, self::BCRYPT_HASH, '');
        $this->assertEquals(self::BCRYPT_VERIFY, $result);
    }

    public function testVerifyLegacy()
    {
        $result = $this->passwordGenerator->verify(self::BASE_PASSWORD, self::LEGACY_HASH, '');
        $this->assertEquals(self::LEGACY_VERIFY, $result);
    }

    private function mockBcryptHasher()
    {
        $mock = \Mockery::mock(Hasher::class);
        $mock->shouldReceive('make')
            ->atMost(1)
            ->andReturn(self::BCRYPT_HASH)
        ;
        $mock->shouldReceive('check')
            ->atMost(1)
            ->andReturn(self::BCRYPT_VERIFY)
        ;

        return $mock;
    }

    private function mockLegacyHasher()
    {
        $mock = \Mockery::mock(HashWrapper::class);
        $mock->shouldReceive('hash')
            ->atMost(1)
            ->with('sha256', \Mockery::any())
            ->andReturn(self::LEGACY_HASH)
        ;
        $mock->shouldReceive('hashEquals')
            ->atMost(1)
            ->andReturn(self::LEGACY_VERIFY)
        ;
        $mock->shouldReceive('sha1')
            ->atMost(1)
            ->andReturn(self::SHA1)
        ;

        return $mock;
    }
}
