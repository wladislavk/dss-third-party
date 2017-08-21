<?php

namespace Tests\Unit\Helpers;

use Carbon\Carbon;
use DateTime;
use DentalSleepSolutions\Exceptions\JWT\ExpiredTokenException;
use DentalSleepSolutions\Exceptions\JWT\InactiveTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidPayloadException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Helpers\JwtHelper;
use DentalSleepSolutions\Structs\JwtPayload;
use Illuminate\Config\Repository as Config;
use Tests\TestCases\UnitTestCase;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Providers\JWT\JWTInterface;

class JwtHelperTest extends UnitTestCase
{
    const TOKEN = 'token';
    const TTL = 60;
    const PAYLOAD = ['ttl' => self::TTL];
    const EXPECTED_VALUES = ['foo' => 'bar'];
    const EXPECTED_SET = 'bar';

    /** @var Config */
    private $config;

    /** @var Carbon */
    private $carbon;

    /** @var JWTInterface */
    private $jwtProvider;

    /** @var JwtPayload */
    private $claims;

    /** @var JwtHelper */
    private $helper;

    public function setUp()
    {
        $this->config = $this->mockConfig();
        $this->carbon = $this->mockCarbon();
        $this->jwtProvider = $this->mockJwtProvider();
        $this->helper = new JwtHelper($this->config, $this->carbon, $this->jwtProvider);
    }

    public function testCreateToken()
    {
        $claims = [];
        $expireDate = null;
        $notBefore = null;
        $token = $this->helper->createToken($claims, $expireDate, $notBefore);
        $this->assertEquals(self::TOKEN, $token);
    }

    public function testCreateTokenExpireDate()
    {
        $claims = [];
        $expireDate = $this->mockDate();
        $notBefore = null;
        $token = $this->helper->createToken($claims, $expireDate, $notBefore);
        $this->assertEquals(self::TOKEN, $token);
    }

    public function testCreateTokenNotBefore()
    {
        $claims = [];
        $expireDate = null;
        $notBefore = $this->mockDate();
        $token = $this->helper->createToken($claims, $expireDate, $notBefore);
        $this->assertEquals(self::TOKEN, $token);
    }

    public function testCreateTokenBothDates()
    {
        $claims = [];
        $expireDate = $this->mockDate();
        $notBefore = $this->mockDate();
        $token = $this->helper->createToken($claims, $expireDate, $notBefore);
        $this->assertEquals(self::TOKEN, $token);
    }
    
    public function testParseToken()
    {
        $this->jwtProvider
            ->shouldReceive('decode')
            ->with(self::TOKEN)
            ->andReturn(self::PAYLOAD)
        ;

        $payload = $this->helper->parseToken(self::TOKEN);
        $this->assertEquals(self::PAYLOAD, $payload);
    }

    public function testParseTokenException()
    {
        $this->jwtProvider
            ->shouldReceive('decode')
            ->with(self::TOKEN)
            ->andThrow(new TokenInvalidException())
        ;

        $this->expectException(InvalidTokenException::class);
        $this->helper->parseToken(self::TOKEN);
    }

    public function testValidateClaimsInvalidIssuer()
    {
        $payload = new JwtPayload();
        $payload->issuer = '';

        $this->expectException(InvalidTokenException::class);
        $this->expectExceptionMessageRegExp('/^Invalid Issuer \(iss\)/');
        $this->helper->validateClaims($payload->toArray());
    }

    public function testValidateClaimsInvalidSubject()
    {
        $payload = new JwtPayload();
        $payload->subject = '';

        $this->expectException(InvalidTokenException::class);
        $this->expectExceptionMessageRegExp('/^Invalid Subject \(sub\)/');
        $this->helper->validateClaims($payload->toArray());
    }

    public function testValidateClaimsInvalidAudience()
    {
        $payload = new JwtPayload();
        $payload->audience = '';

        $this->expectException(InvalidTokenException::class);
        $this->expectExceptionMessageRegExp('/^Invalid Audience \(aud\)/');
        $this->helper->validateClaims($payload->toArray());
    }

    public function testValidateClaimsInvalidNotBefore()
    {
        $this->carbon
            ->shouldReceive('timestamp')
            ->once()
            ->andReturnSelf()
        ;
        $this->carbon
            ->shouldReceive('isFuture')
            ->once()
            ->andReturn(true)
        ;

        $payload = new JwtPayload();

        $this->expectException(InactiveTokenException::class);
        $this->expectExceptionMessageRegExp('/^Not Before \(nbf\)/');
        $this->helper->validateClaims($payload->toArray());
    }

    public function testValidateClaimsInvalidIssuedAt()
    {
        $this->carbon
            ->shouldReceive('timestamp')
            ->twice()
            ->andReturnSelf()
        ;
        $this->carbon
            ->shouldReceive('isFuture')
            ->twice()
            ->andReturnValues([false, true])
        ;

        $payload = new JwtPayload();

        $this->expectException(InvalidTokenException::class);
        $this->expectExceptionMessageRegExp('/^Issued At \(iat\)/');
        $this->helper->validateClaims($payload->toArray());
    }

    public function testValidateClaimsInvalidExpireDate()
    {
        $this->carbon
            ->shouldReceive('timestamp')
            ->times(3)
            ->andReturnSelf()
        ;
        $this->carbon
            ->shouldReceive('isFuture')
            ->twice()
            ->andReturn(false)
        ;
        $this->carbon
            ->shouldReceive('isPast')
            ->once()
            ->andReturn(true)
        ;

        $payload = new JwtPayload();

        $this->expectException(ExpiredTokenException::class);
        $this->expectExceptionMessage('Token has expired (exp)');
        $this->helper->validateClaims($payload->toArray());
    }

    public function testValidateClaimsInvalidExpectedValue()
    {
        $this->carbon
            ->shouldReceive('timestamp')
            ->times(3)
            ->andReturnSelf()
        ;
        $this->carbon
            ->shouldReceive('isFuture')
            ->twice()
            ->andReturn(false)
        ;
        $this->carbon
            ->shouldReceive('isPast')
            ->once()
            ->andReturn(false)
        ;

        $payload = new JwtPayload();

        $this->expectException(InvalidPayloadException::class);
        $this->expectExceptionMessage("Claim (foo) not set or value mismatch: expected 'bar'");
        $this->helper->validateClaims($payload->toArray(), self::EXPECTED_VALUES);
    }

    public function testValidateClaimsInvalidSetValues()
    {
        $this->carbon
            ->shouldReceive('timestamp')
            ->times(3)
            ->andReturnSelf()
        ;
        $this->carbon
            ->shouldReceive('isFuture')
            ->twice()
            ->andReturn(false)
        ;
        $this->carbon
            ->shouldReceive('isPast')
            ->once()
            ->andReturn(false)
        ;

        $payload = new JwtPayload();
        $payload = array_merge($payload->toArray(), self::EXPECTED_VALUES);

        $this->expectException(InvalidPayloadException::class);
        $this->expectExceptionMessage("Claim (bar) not set");
        $this->helper->validateClaims($payload, self::EXPECTED_VALUES, [self::EXPECTED_SET]);
    }

    public function testValidateClaims()
    {
        $this->carbon
            ->shouldReceive('timestamp')
            ->times(3)
            ->andReturnSelf()
        ;
        $this->carbon
            ->shouldReceive('isFuture')
            ->twice()
            ->andReturn(false)
        ;
        $this->carbon
            ->shouldReceive('isPast')
            ->once()
            ->andReturn(false)
        ;

        $payload = new JwtPayload();
        $payload = array_merge($payload->toArray(), self::EXPECTED_VALUES);
        $payload[self::EXPECTED_SET] = 'foo';

        $this->helper->validateClaims($payload, self::EXPECTED_VALUES, [self::EXPECTED_SET]);
    }

    private function mockConfig()
    {
        $mock = \Mockery::mock(Config::class);
        $mock->shouldReceive('get')
            ->atMost(1)
            ->with('jwt.ttl', 0)
            ->andReturn(self::TTL)
        ;
        return $mock;
    }

    private function mockDate()
    {
        $mock = \Mockery::mock(DateTime::class);
        $mock->shouldReceive('getTimestamp')
            ->once()
            ->andReturn(0)
        ;

        return $mock;
    }

    public function mockCarbon()
    {
        $mock = \Mockery::mock(Carbon::class);
        $mock->shouldReceive('now')
            ->atMost(1)
            ->andReturnSelf()
        ;
        $mock->shouldReceive('copy')
            ->atMost(2)
            ->andReturnUsing([$this, 'mockCarbon'])
        ;
        $mock->shouldReceive('addSeconds')
            ->atMost(1)
        ;
        $mock->shouldReceive('getTimestamp')
            ->atMost(1)
            ->andReturn(0)
        ;

        return $mock;
    }

    private function mockJwtProvider()
    {
        $mock = \Mockery::mock(JWTInterface::class);
        $mock->shouldReceive('encode')
            ->atMost(1)
            ->andReturn(self::TOKEN)
        ;

        return $mock;
    }
}
