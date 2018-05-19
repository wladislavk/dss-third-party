<?php

namespace DentalSleepSolutions\Auth;

use DentalSleepSolutions\Exceptions\Auth\AuthenticatableNotFoundException;
use DentalSleepSolutions\Exceptions\JWT\ExpiredTokenException;
use DentalSleepSolutions\Exceptions\JWT\InactiveTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidPayloadException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use DentalSleepSolutions\Providers\Auth\AbstractGuard;
use DentalSleepSolutions\Providers\Auth\AdminGuard;
use DentalSleepSolutions\Providers\Auth\PatientGuard;
use DentalSleepSolutions\Providers\Auth\UserGuard;
use DentalSleepSolutions\Structs\JwtAuthErrors;
use Illuminate\Contracts\Auth\Authenticatable;

class JwtAuth
{
    const CLAIM_ID_INDEX = 'id';
    const CLAIM_ROLE_INDEX = 'role';
    const MODEL_KEY = 'id';
    const ROLE_ADMIN = 'Admin';
    const ROLE_USER = 'User';
    const ROLE_PATIENT = 'Patient';

    /** @var PatientGuard */
    private $patientGuard;

    /** @var UserGuard */
    private $userGuard;

    /** @var AdminGuard */
    private $adminGuard;

    /** @var JwtHelper */
    private $jwtHelper;

    /**
     * @param PatientGuard $patientGuard
     * @param UserGuard    $userGuard
     * @param AdminGuard   $adminGuard
     * @param JwtHelper    $jwtHelper
     */
    public function __construct(
        PatientGuard $patientGuard,
        UserGuard $userGuard,
        AdminGuard $adminGuard,
        JwtHelper $jwtHelper
    )
    {
        $this->patientGuard = $patientGuard;
        $this->userGuard = $userGuard;
        $this->adminGuard = $adminGuard;
        $this->jwtHelper = $jwtHelper;
    }

    /**
     * @param string $role
     * @return string
     * @throws AuthenticatableNotFoundException
     * @throws ExpiredTokenException
     * @throws InactiveTokenException
     * @throws InvalidPayloadException
     * @throws InvalidTokenException
     */
    public function toToken($role = '')
    {
        $guard = $this->guard($role);
        $user = $guard->user();
        if (!$user) {
            throw new AuthenticatableNotFoundException();
        }
        $token = $this->jwtHelper->createToken([
            self::CLAIM_ROLE_INDEX => $role,
            self::CLAIM_ID_INDEX  => $user->getAuthIdentifier(),
        ]);
        return $token;
    }

    /**
     * @param string $role
     * @param string $token
     * @return Authenticatable|null
     * @throws ExpiredTokenException
     * @throws InactiveTokenException
     * @throws InvalidTokenException
     * @throws InvalidPayloadException
     * @throws AuthenticatableNotFoundException
     */
    public function toRole($role, $token)
    {
        $claims = $this->jwtHelper->parseToken($token);
        $this->jwtHelper->validateClaims($claims, [self::CLAIM_ROLE_INDEX => $role], [self::CLAIM_ID_INDEX]);
        $authenticated = $this->guard($role)->once([self::MODEL_KEY => $claims[self::CLAIM_ID_INDEX]]);
        if (!$authenticated) {
            throw new AuthenticatableNotFoundException(JwtAuthErrors::USER_NOT_FOUND);
        }
        $guard = $this->guard($role);
        return $guard->user();
    }

    /**
     * @param string $role
     * @return AbstractGuard
     */
    public function guard($role = self::ROLE_USER)
    {
        if ($role === self::ROLE_ADMIN) {
            return $this->adminGuard;
        }

        if ($role === self::ROLE_PATIENT) {
            return $this->patientGuard;
        }

        return $this->userGuard;
    }
}
