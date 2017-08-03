<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalCompanyRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalUserRepository;
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

    /** @var ExternalCompanyRepository */
    protected $externalCompaniesRepository;

    /** @var ExternalUserRepository */
    protected $externalUsersRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var UserViewRepository */
    private $userViewRepository;

    public function __construct(
        ExternalCompanyRepository $externalCompanyRepository,
        ExternalUserRepository $externalUserRepository,
        Request $request,
        UserViewRepository $userViewRepository,
        UserRepository $userRepository
    ) {
        $this->externalCompaniesRepository = $externalCompanyRepository;
        $this->externalUsersRepository = $externalUserRepository;
        $this->userRepository = $userRepository;
        $this->userViewRepository = $userViewRepository;
        $this->currentUser = $this->getUserInfo($request);
    }

    /**
     * @param Request $request
     * @return UserView|null
     */
    private function getUserInfo(Request $request)
    {
        $this->externalCompanyKey = $request->input('api_key_company');
        $this->externalUserKey = $request->input('api_key_user');

        $externalUser = $this->externalUsersRepository->findByApiKey($this->externalUserKey);
        if (!$externalUser) {
            return null;
        }
        $user = $this->userViewRepository->find('u_' . $externalUser->user_id)->first();

        $user->id = $externalUser->user_id;
        $user->docid = $this->userRepository->getDocId($user->id)->docid ?: $user->userid;
        $user->user_type = $this->userRepository->getUserType($user->docid)->user_type ?: 0;

        return $user;
    }
}
