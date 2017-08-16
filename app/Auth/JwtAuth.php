<?php

namespace DentalSleepSolutions\Auth;

use DentalSleepSolutions\Helpers\JwtHelper;
use Illuminate\Contracts\Auth\Authenticatable;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Structs\JwtAuthErrors;
use DentalSleepSolutions\Exceptions\JWT\InvalidPayloadException;
use DentalSleepSolutions\Exceptions\JWT\ExpiredTokenException;
use DentalSleepSolutions\Exceptions\JWT\InactiveTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Exceptions\Auth\UserNotFoundException;

class JwtAuth
{
    /** @var UserGuard */
    private $userGuard;

    /** @var AdminGuard */
    private $adminGuard;

    /** @var JwtHelper */
    private $tokenHelper;

    /** @var Request */
    private $request;

    public function __construct(
        UserGuard $userGuard,
        AdminGuard $adminGuard,
        JwtHelper $tokenHelper,
        Request $request
    )
    {
        $this->userGuard = $userGuard;
        $this->adminGuard = $adminGuard;
        $this->tokenHelper = $tokenHelper;
        $this->request = $request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Authenticatable
     * @throws ExpiredTokenException
     * @throws InactiveTokenException
     * @throws InvalidTokenException
     * @throws InvalidPayloadException
     * @throws UserNotFoundException
     */
    public function toAdmin()
    {
        return $this->toRole('Admin');
    }

    /**
     * @return Authenticatable
     * @throws ExpiredTokenException
     * @throws InactiveTokenException
     * @throws InvalidTokenException
     * @throws InvalidPayloadException
     * @throws UserNotFoundException
     */
    public function toUser()
    {
        return $this->toRole('User');
    }

    /**
     * @param string $role
     * @return string
     * @throws UserNotFoundException
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
            throw new UserNotFoundException();
        }

        $role = strtolower($role);
        $token = $this->tokenHelper->createToken([$role => $user->getAuthIdentifier()]);

        return $token;
    }

    /**
     * @param string $role
     * @return Authenticatable|null
     * @throws ExpiredTokenException
     * @throws InactiveTokenException
     * @throws InvalidTokenException
     * @throws InvalidPayloadException
     * @throws UserNotFoundException
     */
    public function toRole($role)
    {
        $token = $this->getTokenFromHeader();
        $claims = $this->tokenHelper->parseToken($token);

        $this->tokenHelper->validateClaims($claims);

        $claimRole = strtolower($role);

        if (!isset($claims[$claimRole])) {
            throw new InvalidPayloadException(JwtAuthErrors::INVALID_ROLE);
        }

        $id = $claims[$claimRole];

        $authenticated = $this->guard($role)
            ->once(['id' => $id])
        ;

        if (!$authenticated) {
            throw new UserNotFoundException(JwtAuthErrors::USER_NOT_FOUND);
        }

        return $this->guard($role)
            ->user()
            ;
    }

    /**
     * @param string $role
     * @return AbstractGuard|null
     */
    public function guard($role = 'User')
    {
        if ($role === 'Admin') {
            return $this->adminGuard;
        }

        if ($role === 'User') {
            return $this->userGuard;
        }

        return null;
    }

    /**
     * @return string
     */
    private function getTokenFromHeader()
    {
        $header = $this->request->header('Authorization','');
        $token = preg_replace('/^Bearer /', '', $header);
        return $token;
    }
}
