<?php

namespace DentalSleepSolutions\Auth;

use DentalSleepSolutions\Exceptions\Auth\AuthenticatableNotFoundException;
use DentalSleepSolutions\Exceptions\JWT\EmptyTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Providers\Auth\AbstractGuard;
use DentalSleepSolutions\Providers\Auth\DentrixUserGuard;
use DentalSleepSolutions\Providers\Auth\DentrixCompanyGuard;
use DentalSleepSolutions\Providers\Auth\UserGuard;
use DentalSleepSolutions\Structs\DentrixAuthErrors;
use Illuminate\Contracts\Auth\Authenticatable;

class DentrixAuth
{
    /** @var DentrixCompanyGuard */
    private $dentrixCompanyGuard;

    /** @var DentrixUserGuard */
    private $dentrixUserGuard;

    /** @var UserGuard */
    private $userGuard;

    /**
     * @param DentrixCompanyGuard $dentrixCompanyGuard
     * @param DentrixUserGuard    $dentrixUserGuard
     * @param UserGuard           $userGuard
     */
    public function __construct(
        DentrixCompanyGuard $dentrixCompanyGuard,
        DentrixUserGuard $dentrixUserGuard,
        UserGuard $userGuard
    )
    {
        $this->dentrixCompanyGuard = $dentrixCompanyGuard;
        $this->dentrixUserGuard = $dentrixUserGuard;
        $this->userGuard = $userGuard;
    }

    /**
     * @param string $role
     * @param string $token
     * @return Authenticatable
     * @throws EmptyTokenException
     * @throws InvalidTokenException
     * @throws AuthenticatableNotFoundException
     */
    public function toRole($role, $token)
    {
        if ($role !== 'DentrixCompany' && $role !== 'DentrixUser') {
            return $this->toUser($token);
        }

        if (!strlen($token)) {
            if ($role === 'DentrixCompany') {
                throw new EmptyTokenException(DentrixAuthErrors::COMPANY_TOKEN_MISSING);
            }

            throw new EmptyTokenException(DentrixAuthErrors::USER_TOKEN_MISSING);
        }

        $authenticated = $this->guard($role)
            ->once([
                'api_key' => $token
            ])
        ;

        if (!$authenticated) {
            if ($role === 'DentrixCompany') {
                throw new AuthenticatableNotFoundException(DentrixAuthErrors::COMPANY_TOKEN_INVALID);
            }

            throw new AuthenticatableNotFoundException(DentrixAuthErrors::USER_TOKEN_INVALID);
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
        if ($role === 'DentrixCompany') {
            return $this->dentrixCompanyGuard;
        }

        if ($role === 'DentrixUser') {
            return $this->dentrixUserGuard;
        }

        return $this->userGuard;
    }

    /**
     * @param string|int $id
     * @return Authenticatable
     * @throws AuthenticatableNotFoundException
     */
    private function toUser($id)
    {
        $authenticated = $this->guard('User')
            ->loginUsingId($id)
        ;

        if (!$authenticated) {
            throw new AuthenticatableNotFoundException(DentrixAuthErrors::USER_TOKEN_INVALID);
        }

        return $this->guard('User')
            ->user()
            ;
    }
}
