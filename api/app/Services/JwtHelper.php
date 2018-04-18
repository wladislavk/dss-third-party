<?php

namespace DentalSleepSolutions\Services;

use DateTime;
use Carbon\Carbon;
use DentalSleepSolutions\Auth\JwtAuth;
use Illuminate\Config\Repository as Config;
use DentalSleepSolutions\Structs\JwtPayload;
use Tymon\JWTAuth\Contracts\Providers\JWT as JWTInterface;
use DentalSleepSolutions\Exceptions\JWT\InvalidPayloadException;
use DentalSleepSolutions\Exceptions\JWT\ExpiredTokenException;
use DentalSleepSolutions\Exceptions\JWT\InactiveTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;

class JwtHelper
{
    /** @var Config */
    private $config;

    /** @var Carbon */
    private $carbon;

    /** @var JWTInterface */
    private $jwtProvider;

    public function __construct(
        Config $config,
        Carbon $carbon,
        JWTInterface $jwtProvider
    ) {
        $this->config = $config;
        $this->carbon = $carbon;
        $this->jwtProvider = $jwtProvider;
    }

    /**
     * @param array    $customClaims
     * @param DateTime $notBefore
     * @param DateTime $expireDate
     * @return string
     */
    public function createToken(array $customClaims = [], DateTime $expireDate = null, DateTime $notBefore = null)
    {
        $now = $this->carbon->now();

        if (is_null($notBefore)) {
            $notBefore = $now->copy();
        }

        if (is_null($expireDate)) {
            $expireDate = $now->copy();
            $expireDate->addSeconds($this->config->get('jwt.ttl', 0));
        }

        $payload = new JwtPayload();
        $payload->issuedAt = $now->getTimestamp();
        $payload->notBefore = $notBefore->getTimestamp();
        $payload->expiresAt = $expireDate->getTimestamp();
        $payload->jwtUniqueId = md5($payload->issuer . '-' . $payload->issuedAt);
        if (isset($customClaims[JwtAuth::CLAIM_ID_INDEX])) {
            $payload->subject = $customClaims[JwtAuth::CLAIM_ID_INDEX];
        }

        $baseClaims = $payload->toArray();
        $claims = array_merge($baseClaims, $customClaims);

        $token = $this->jwtProvider->encode($claims);

        return $token;
    }

    /**
     * @param string $token
     * @return array
     */
    public function parseToken($token)
    {
        $payload = $this->jwtProvider->decode($token);
        return $payload;
    }

    /**
     * @param array $claims
     * @param array $expectedValues
     * @param array $expectedSet
     * @throws InvalidTokenException
     * @throws InactiveTokenException
     * @throws ExpiredTokenException
     * @throws InvalidPayloadException
     */
    public function validateClaims(array $claims, array $expectedValues = [], array $expectedSet = [])
    {
        $payload = new JwtPayload();

        $issuer = '';
        $audience = '';

        if (isset($claims['iss'])) {
            $issuer = $claims['iss'];
        }

        if (isset($claims['aud'])) {
            $audience = $claims['aud'];
        }

        if ($issuer !== $payload->issuer) {
            throw new InvalidTokenException("Invalid Issuer (iss): expected '{$payload->issuer}', got '$issuer'");
        }

        if ($audience !== $payload->audience) {
            throw new InvalidTokenException("Invalid Audience (aud): expected '{$payload->audience}', got '$audience'");
        }
        
        if (isset($claims['nbf']) && $this->carbon->setTimestamp($claims['nbf'])->isFuture()) {
            throw new InactiveTokenException('Not Before (nbf) timestamp cannot be in the future');
        }

        if (isset($claims['iat']) && $this->carbon->setTimestamp($claims['iat'])->isFuture()) {
            throw new InvalidTokenException('Issued At (iat) timestamp cannot be in the future');
        }

        if (!isset($claims['exp']) || $this->carbon->setTimestamp($claims['exp'])->isPast()) {
            throw new ExpiredTokenException('Token has expired (exp)');
        }

        foreach ($expectedValues as $claim => $value) {
            if (!isset($claims[$claim]) || $claims[$claim] !== $value) {
                throw new InvalidPayloadException("Claim ($claim) not set or value mismatch: expected '$value'");
            }
        }

        foreach ($expectedSet as $claim) {
            if (!isset($claims[$claim])) {
                throw new InvalidPayloadException("Claim ($claim) not set");
            }
        }
    }
}
