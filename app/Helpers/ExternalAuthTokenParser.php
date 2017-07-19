<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Contracts\Repositories\ExternalCompanies;
use DentalSleepSolutions\Contracts\Repositories\ExternalUsers;
use DentalSleepSolutions\Eloquent\User as UserView;

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

    /** @var ExternalCompanies */
    private $companiesRepository;

    /** @var ExternalUsers */
    private $usersRepository;

    /** @var UserView */
    private $userView;

    /** @var string */
    private $error;

    /**
     * ExternalAuthTokenParser constructor.
     *
     * @param ExternalCompanies $companiesRepository
     * @param ExternalUsers     $usersRepository
     * @param UserView          $userView
     */
    public function __construct(
        ExternalCompanies $companiesRepository,
        ExternalUsers $usersRepository,
        UserView $userView
    )
    {
        $this->companiesRepository = $companiesRepository;
        $this->usersRepository = $usersRepository;
        $this->userView = $userView;

        $this->setError(self::NO_ERROR);
    }

    /**
     * @param string $companyKey
     * @param string $userKey
     * @return UserView|null
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

        $externalCompany = $this->companiesRepository->where('api_key', $companyKey)->first();

        if (!$externalCompany) {
            $this->setError(self::COMPANY_KEY_INVALID);
            return null;
        }

        $externalUser = $this->usersRepository->where('api_key', $userKey)->first();

        if (!$externalUser) {
            $this->setError(self::USER_KEY_INVALID);
            return null;
        }

        $user = $this->userView->find('u_' . $externalUser->user_id)->first();

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
