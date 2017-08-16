<?php

namespace DentalSleepSolutions\Helpers;

use DateTime;
use Carbon\Carbon;
use Illuminate\Config\Repository as Config;
use DentalSleepSolutions\Structs\JwtPayload;
use Tymon\JWTAuth\Providers\JWT\JWTInterface;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
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
    )
    {
        $this->config = $config;
        $this->carbon = $carbon;
        $this->jwtProvider = $jwtProvider;
    }

    /**
     * @param array    $customClaims
     * @param DateTime $notBefore
     * @param DateTime $expireDate
     * @return string
     * @throws InvalidPayloadException
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
        $payload->iat = $now->getTimestamp();
        $payload->nbf = $notBefore->getTimestamp();
        $payload->exp = $expireDate->getTimestamp();
        $payload->jti = $payload->iss . '-' . $payload->iat;

        $baseClaims = $payload->toArray();
        $claims = array_merge($customClaims, $baseClaims);

        try {
            $token = $this->jwtProvider->encode($claims);
        } catch (JWTException $e) {
            throw new InvalidPayloadException($e->getMessage());
        }

        return $token;
    }

    /**
     * @param string $token
     * @return array
     * @throws InvalidTokenException
     */
    public function parseToken($token)
    {
        try {
            $payload = $this->jwtProvider->decode($token);
        } catch (TokenInvalidException $e) {
            throw new InvalidTokenException($e->getMessage());
        }

        \Log::info(__FUNCTION__, $payload);

        return $payload;
    }

    /**
     * @param array $claims
     * @throws InvalidTokenException
     * @throws InactiveTokenException
     * @throws ExpiredTokenException
     */
    public function validateClaims(array $claims)
    {
        $payload = new JwtPayload();

        $issuer = '';
        $subject = '';
        $audience = '';

        if (isset($claims['iss'])) {
            $issuer = $claims['iss'];
        }

        if (isset($claims['sub'])) {
            $subject = $claims['sub'];
        }

        if (isset($claims['aud'])) {
            $audience = $claims['aud'];
        }

        if ($issuer !== $payload->iss) {
            throw new InvalidTokenException("Invalid Issuer (iss): got '$issuer', expected '{$payload->iss}'");
        }

        if ($subject !== $payload->sub) {
            throw new InvalidTokenException("Invalid Subject (sub): got '$subject', expected '{$payload->sub}'");
        }

        if ($audience !== $payload->aud) {
            throw new InvalidTokenException("Invalid Audience (aud): got '$audience', expected '{$payload->aud}'");
        }
        
        if (isset($claims['nbf']) && $this->carbon->timestamp($claims['nbf'])->isFuture()) {
            throw new InactiveTokenException('Not Before (nbf) timestamp cannot be in the future');
        }

        if (isset($claims['iat']) && $this->carbon->timestamp($claims['iat'])->isFuture()) {
            throw new InvalidTokenException('Issued At (iat) timestamp cannot be in the future');
        }

        if (!isset($claims['exp']) || $this->carbon->timestamp($claims['exp'])->isPast()) {
            throw new ExpiredTokenException('Token has expired (exp)');
        }
    }
}
