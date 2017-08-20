<?php

namespace DentalSleepSolutions\Auth;

use DentalSleepSolutions\Exceptions\Auth\AuthenticatableNotFoundException;
use DentalSleepSolutions\Exceptions\JWT\ExpiredTokenException;
use DentalSleepSolutions\Exceptions\JWT\InactiveTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidPayloadException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Helpers\JwtHelper;
use DentalSleepSolutions\Providers\Auth\AbstractGuard;
use DentalSleepSolutions\Providers\Auth\AdminGuard;
use DentalSleepSolutions\Providers\Auth\UserGuard;
use DentalSleepSolutions\Structs\JwtAuthErrors;
use Illuminate\Contracts\Auth\Authenticatable;

class JwtAuth
{
    /** @var UserGuard */
    private $userGuard;

    /** @var AdminGuard */
    private $adminGuard;

    /** @var JwtHelper */
    private $jwtHelper;

    /**
     * @param UserGuard  $userGuard
     * @param AdminGuard $adminGuard
     * @param JwtHelper  $jwtHelper
     */
    public function __construct(
        UserGuard $userGuard,
        AdminGuard $adminGuard,
        JwtHelper $jwtHelper
    )
    {
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
        $user = $this->guard($role)
            ->user()
        ;

        if (!$user) {
            throw new AuthenticatableNotFoundException();
        }

        $token = $this->jwtHelper
            ->createToken([
                'role' => $role,
                'id'  => $user->getAuthIdentifier(),
            ])
        ;

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
        $this->jwtHelper->validateClaims($claims, ['role' => $role], ['id']);

        $authenticated = $this->guard($role)
            ->once([
                'id' => $claims['id']
            ])
        ;

        if (!$authenticated) {
            throw new AuthenticatableNotFoundException(JwtAuthErrors::USER_NOT_FOUND);
        }

        return $this->guard($role)
            ->user()
            ;
    }

    /**
     * @param string $role
     * @return AbstractGuard
     */
    public function guard($role = 'User')
    {
        if ($role === 'Admin') {
            return $this->adminGuard;
        }

        return $this->userGuard;
    }
}
