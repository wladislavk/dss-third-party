<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalCompanyRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalUserRepository;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\StaticClasses\SudoHelper;

/**
 * Class ExternalAuthTokenParser
 */
class ExternalAuthTokenParser
{
    const NO_ERROR = '';
    const COMPANY_KEY_MISSING = 'Company key is missing';
    const USER_KEY_MISSING = 'User key is missing';
    const COMPANY_KEY_INVALID = 'Company key is not valid';
    const USER_KEY_INVALID = 'User key is not valid';

    /** @var ExternalCompanyRepository */
    private $externalCompanyRepository;

    /** @var ExternalUserRepository */
    private $externalUserRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var string */
    private $error;

    /**
     * ExternalAuthTokenParser constructor.
     *
     * @param ExternalCompanyRepository $externalCompanyRepository
     * @param ExternalUserRepository    $externalUserRepository
     * @param UserRepository            $userRepository
     */
    public function __construct(
        ExternalCompanyRepository $externalCompanyRepository,
        ExternalUserRepository $externalUserRepository,
        UserRepository $userRepository
    )
    {
        $this->externalCompanyRepository = $externalCompanyRepository;
        $this->externalUserRepository = $externalUserRepository;
        $this->userRepository = $userRepository;

        $this->setError(self::NO_ERROR);
    }

    /**
     * @param string $companyKey
     * @param string $userKey
     * @return User|null
     */
    public function getUserData($companyKey, $userKey)
    {
        $this->setError(self::NO_ERROR);

        if (!strlen($companyKey)) {
            $this->setError(self::COMPANY_KEY_MISSING);
            return null;
        }

        if (!strlen($userKey)) {
            $this->setError(self::USER_KEY_MISSING);
            return null;
        }

        $externalCompany = $this->externalCompanyRepository->findWhere(['api_key' => $companyKey])->first();

        if (!$externalCompany) {
            $this->setError(self::COMPANY_KEY_INVALID);
            return null;
        }

        $externalUser = $this->externalUserRepository->findWhere(['api_key' => $userKey])->first();

        if (!$externalUser) {
            $this->setError(self::USER_KEY_INVALID);
            return null;
        }

        $user = $this->userRepository->find(SudoHelper::USER_PREFIX . $externalUser->user_id)->first();

        if (!$user) {
            $this->setError(self::USER_KEY_INVALID);
            return null;
        }

        $user->id = $externalUser->user_id;

        return $user;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    private function setError($error)
    {
        $this->error = $error;
    }
}
