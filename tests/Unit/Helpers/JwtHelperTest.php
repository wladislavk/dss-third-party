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
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Providers\JWT\JWTInterface;

class JwtHelperTest extends UnitTestCase
{
    const EXPECTED_VALUES = ['foo' => 'bar'];
    const EXPECTED_SET = 'bar';
    const TOKEN = 'token';
    const TOKEN_FLAG = 'flag';
    const TTL = 60;
    const PAYLOAD = ['ttl' => self::TTL];
    const TIMESTAMP_FLAG = 631152000;

    /** @var string */
    private $carbonState;

    /** @var JwtHelper */
    private $helper;

    public function setUp()
    {
        $this->carbonState = 0;
        $config = $this->mockConfig();
        $carbon = $this->mockCarbon();
        $jwtProvider = $this->mockJwtProvider();
        $this->helper = new JwtHelper($config, $carbon, $jwtProvider);
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
        $payload = $this->helper->parseToken(self::TOKEN);
        $this->assertEquals(self::PAYLOAD, $payload);
    }

    public function testParseTokenException()
    {
        $this->expectException(InvalidTokenException::class);
        $this->helper->parseToken(self::TOKEN_FLAG);
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
        $payload = new JwtPayload();
        $payload->notBefore = self::TIMESTAMP_FLAG;

        $this->expectException(InactiveTokenException::class);
        $this->expectExceptionMessageRegExp('/^Not Before \(nbf\)/');
        $this->helper->validateClaims($payload->toArray());
    }

    public function testValidateClaimsInvalidIssuedAt()
    {
        $payload = new JwtPayload();
        $payload->issuedAt = self::TIMESTAMP_FLAG;

        $this->expectException(InvalidTokenException::class);
        $this->expectExceptionMessageRegExp('/^Issued At \(iat\)/');
        $this->helper->validateClaims($payload->toArray());
    }

    public function testValidateClaimsInvalidExpireDate()
    {
        $payload = new JwtPayload();
        $payload->expiresAt = self::TIMESTAMP_FLAG;

        $this->expectException(ExpiredTokenException::class);
        $this->expectExceptionMessage('Token has expired (exp)');
        $this->helper->validateClaims($payload->toArray());
    }

    public function testValidateClaimsInvalidExpectedValue()
    {
        $payload = new JwtPayload();

        $this->expectException(InvalidPayloadException::class);
        $this->expectExceptionMessage("Claim (foo) not set or value mismatch: expected 'bar'");
        $this->helper->validateClaims($payload->toArray(), self::EXPECTED_VALUES);
    }

    public function testValidateClaimsInvalidSetValues()
    {
        $payload = new JwtPayload();
        $payload = array_merge($payload->toArray(), self::EXPECTED_VALUES);

        $this->expectException(InvalidPayloadException::class);
        $this->expectExceptionMessage("Claim (bar) not set");
        $this->helper->validateClaims($payload, self::EXPECTED_VALUES, [self::EXPECTED_SET]);
    }

    // @todo: provide assertions for this test
    /*
    public function testValidateClaims()
    {
        $payload = new JwtPayload();
        $payload = array_merge($payload->toArray(), self::EXPECTED_VALUES);
        $payload[self::EXPECTED_SET] = 'foo';

        $this->helper->validateClaims($payload, self::EXPECTED_VALUES, [self::EXPECTED_SET]);
    }*/

    private function mockConfig()
    {
        /** @var Config|MockInterface $mock */
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
        /** @var Carbon|MockInterface $mock */
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
        $mock->shouldReceive('setTimestamp')
            ->atMost(3)
            ->andReturnUsing(function ($timestamp) use ($mock) {
                $this->carbonState = $timestamp;
                return $mock;
            })
        ;
        $mock->shouldReceive('isFuture')
            ->atMost(2)
            ->andReturnUsing(function () {
                if (self::TIMESTAMP_FLAG === $this->carbonState) {
                    return true;
                }

                return false;
            })
        ;
        $mock->shouldReceive('isPast')
            ->atMost(1)
            ->andReturnUsing(function () {
                if (self::TIMESTAMP_FLAG === $this->carbonState) {
                    return true;
                }

                return false;
            })
        ;

        return $mock;
    }

    private function mockJwtProvider()
    {
        /** @var JWTInterface|MockInterface $mock */
        $mock = \Mockery::mock(JWTInterface::class);
        $mock->shouldReceive('encode')
            ->atMost(1)
            ->andReturn(self::TOKEN)
        ;
        $mock->shouldReceive('decode')
            ->atMost(1)
            ->withAnyArgs([self::TOKEN, self::TOKEN_FLAG])
            ->andReturnUsing(function ($token) {
                if (self::TOKEN_FLAG === $token) {
                    throw new TokenInvalidException();
                }

                return self::PAYLOAD;
            })
        ;

        return $mock;
    }
}
