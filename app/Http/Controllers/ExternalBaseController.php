<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany;
use DentalSleepSolutions\Eloquent\Models\Dental\ExternalUser;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as IlluminateBaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use DentalSleepSolutions\Eloquent\Models\User as UserView;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository as UserViewRepository;

abstract class ExternalBaseController extends IlluminateBaseController
{
    use DispatchesJobs, ValidatesRequests;

    /** @var UserView|null */
    protected $currentUser;

    /** @var string|null */
    protected $externalCompanyKey;

    /** @var string|null */
    protected $externalUserKey;

    /** @var ExternalCompany */
    protected $externalCompaniesRepository;

    /** @var ExternalUser */
    protected $externalUsersRepository;

    public function __construct(
        ExternalCompany $externalCompanies,
        ExternalUser $externalUsers,
        Request $request,
        UserViewRepository $userViewRepository,
        UserRepository $userRepository
    ) {
        $this->externalCompaniesRepository = $externalCompanies;
        $this->externalUsersRepository = $externalUsers;
        $this->currentUser = $this->getUserInfo($request, $userViewRepository, $userRepository);
    }

    /**
     * @param Request $request
     * @param UserViewRepository $userViewRepository
     * @param UserRepository $userRepository
     * @return UserView|null
     */
    private function getUserInfo(
        Request $request,
        UserViewRepository $userViewRepository,
        UserRepository $userRepository
    ) {
        $this->externalCompanyKey = $request->input('api_key_company');
        $this->externalUserKey = $request->input('api_key_user');

        $externalUser = $this->externalUsersRepository->where('api_key', $this->externalUserKey)->first();
        $user = $userViewRepository->find('u_' . $externalUser->user_id)->first();

        $user->id = $externalUser->user_id;
        $user->docid = $userRepository->getDocId($user->id)->docid ?: $user->userid;
        $user->user_type = $userRepository->getUserType($user->docid)->user_type ?: 0;

        return $user;
    }
}
