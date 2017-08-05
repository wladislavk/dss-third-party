<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalCompanyRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalUserRepository;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\Eloquent\Models\User;
use Illuminate\Http\Request;
use DentalSleepSolutions\Structs\ExternalAuthTokenErrors;

/**
 * Class ExternalAuthTokenParser
 */
class ExternalAuthTokenParser
{
    const COMPANY_KEY_INDEX = 'api_key_company';
    const USER_KEY_INDEX = 'api_key_user';

    /** @var ExternalCompanyRepository */
    private $externalCompanyRepository;

    /** @var ExternalUserRepository */
    private $externalUserRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var string */
    private $companyKey;

    /** @var string */
    private $userKey;

    /**
     * ExternalAuthTokenParser constructor.
     *
     * @param ExternalCompanyRepository $externalCompanyRepository
     * @param ExternalUserRepository    $externalUserRepository
     * @param UserRepository            $userRepository
     * @param Request                   $request
     */
    public function __construct(
        ExternalCompanyRepository $externalCompanyRepository,
        ExternalUserRepository $externalUserRepository,
        UserRepository $userRepository,
        Request $request
    )
    {
        $this->externalCompanyRepository = $externalCompanyRepository;
        $this->externalUserRepository = $externalUserRepository;
        $this->userRepository = $userRepository;
        $this->companyKey = $request->input(self::COMPANY_KEY_INDEX, '');
        $this->userKey = $request->input(self::USER_KEY_INDEX, '');
    }

    /**
     * @return User|null
     */
    public function getUserData()
    {
        if ($this->validationError() !== ExternalAuthTokenErrors::NO_ERROR) {
            return null;
        }

        $externalUser = $this->externalUserRepository->findByApiKey($this->userKey);
        $user = $this->userRepository->findByUid($externalUser->user_id);
        $user->id = $externalUser->user_id;

        return $user;
    }

    /**
     * @return string
     */
    public function validationError()
    {
        if (!strlen($this->companyKey)) {
            return ExternalAuthTokenErrors::COMPANY_KEY_MISSING;
        }

        if (!strlen($this->userKey)) {
            return ExternalAuthTokenErrors::USER_KEY_MISSING;
        }

        $externalCompany = $this->externalCompanyRepository->findByApiKey($this->companyKey);

        if (!$externalCompany) {
            return ExternalAuthTokenErrors::COMPANY_KEY_INVALID;
        }

        $externalUser = $this->externalUserRepository->findByApiKey($this->userKey);

        if (!$externalUser) {
            return ExternalAuthTokenErrors::USER_KEY_INVALID;
        }

        $user = $this->userRepository->findByUid($externalUser->user_id);

        if (!$user) {
            return ExternalAuthTokenErrors::USER_NOT_FOUND;
        }

        return ExternalAuthTokenErrors::NO_ERROR;
    }
}
