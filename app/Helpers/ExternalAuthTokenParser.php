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
    /** @var \DentalSleepSolutions\Contracts\Repositories\ExternalCompanies */
    protected $companiesRepository;

    /** @var \DentalSleepSolutions\Contracts\Repositories\ExternalUsers */
    protected $usersRepository;

    /** @var \DentalSleepSolutions\Eloquent\User */
    protected $userView;

    /**
     * ExternalAuthTokenParser constructor.
     *
     * @param \DentalSleepSolutions\Contracts\Repositories\ExternalCompanies $companiesRepository
     * @param \DentalSleepSolutions\Contracts\Repositories\ExternalUsers     $usersRepository
     * @param \DentalSleepSolutions\Eloquent\User                            $userView
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
    }

    /**
     * @param string $companyKey
     * @param string $userKey
     * @return bool|\DentalSleepSolutions\Eloquent\User
     */
    public function getUserData($companyKey, $userKey)
    {
        $externalCompany = $this->companiesRepository->where('api_key', $companyKey)->first();

        if (!$externalCompany) {
            return false;
        }

        $externalUser = $this->usersRepository->where('api_key', $userKey)->first();

        if (!$externalUser) {
            return false;
        }

        $user = $this->userView->find('u_' . $externalUser->user_id)->first();

        if (!$user) {
            return false;
        }

        $user->id = $externalUser->user_id;

        return $user;
    }
}
