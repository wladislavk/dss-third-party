<?php

namespace DentalSleepSolutions\Auth;

use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalCompanyRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalUserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Structs\DentrixAuthErrors;
use DentalSleepSolutions\Exceptions\JWT\EmptyTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Exceptions\Auth\UserNotFoundException;

class DentrixAuth
{
    const COMPANY_TOKEN_INDEX = 'api_key_company';
    const USER_TOKEN_INDEX = 'api_key_user';

    /** @var ExternalCompanyRepository */
    private $externalCompanyRepository;

    /** @var ExternalUserRepository */
    private $externalUserRepository;

    /** @var UserGuard */
    private $guard;

    /** @var Request */
    private $request;

    /**
     * @param ExternalCompanyRepository $externalCompanyRepository
     * @param ExternalUserRepository    $externalUserRepository
     * @param UserGuard                 $guard
     * @param Request                   $request
     */
    public function __construct(
        ExternalCompanyRepository $externalCompanyRepository,
        ExternalUserRepository $externalUserRepository,
        UserGuard $guard,
        Request $request
    )
    {
        $this->externalCompanyRepository = $externalCompanyRepository;
        $this->externalUserRepository = $externalUserRepository;
        $this->guard = $guard;
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
     * @throws EmptyTokenException
     * @throws InvalidTokenException
     * @throws UserNotFoundException
     */
    public function toUser()
    {
        $companyKey = $this->request->input(self::COMPANY_TOKEN_INDEX, '');
        $userKey = $this->request->input(self::USER_TOKEN_INDEX, '');

        if (!strlen($companyKey)) {
            throw new EmptyTokenException(DentrixAuthErrors::COMPANY_TOKEN_MISSING);
        }

        if (!strlen($userKey)) {
            throw new EmptyTokenException(DentrixAuthErrors::USER_TOKEN_MISSING);
        }

        $externalCompany = $this->externalCompanyRepository->findByApiKey($companyKey);

        if (!$externalCompany) {
            throw new InvalidTokenException(DentrixAuthErrors::COMPANY_TOKEN_INVALID);
        }

        $externalUser = $this->externalUserRepository->findByApiKey($userKey);

        if (!$externalUser) {
            throw new InvalidTokenException(DentrixAuthErrors::USER_TOKEN_INVALID);
        }

        $authenticated = $this->guard->once(['user_id' => $externalUser->user_id]);

        if (!$authenticated) {
            throw new UserNotFoundException(DentrixAuthErrors::USER_NOT_FOUND);
        }

        return $this->guard->user();
    }

    /**
     * @return null
     */
    public function toAdmin()
    {
        return null;
    }

    /**
     * @return UserGuard
     */
    public function guard()
    {
        return $this->guard;
    }
}
