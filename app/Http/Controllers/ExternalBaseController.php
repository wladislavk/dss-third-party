<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalCompanyRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalUserRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\StaticClasses\SudoHelper;
use Illuminate\Config\Repository as Config;
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

    /** @var Config */
    protected $config;

    /** @var UserRepository */
    private $userRepository;

    /** @var UserViewRepository */
    private $userViewRepository;

    public function __construct(
        ExternalCompanyRepository $externalCompanyRepository,
        ExternalUserRepository $externalUserRepository,
        Config $config,
        Request $request,
        UserViewRepository $userViewRepository,
        UserRepository $userRepository
    ) {
        $this->externalCompaniesRepository = $externalCompanyRepository;
        $this->externalUsersRepository = $externalUserRepository;
        $this->config = $config;
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

        $user = $this->userViewRepository->find(SudoHelper::USER_PREFIX . $externalUser->user_id)->first();

        if (!$user) {
            return null;
        }

        $user->id = $externalUser->user_id;
        $doctorId = $user->id;
        $userType = 0;

        $getter = $this->userRepository->getDocId($user->id);

        if ($getter) {
            $doctorId = $getter->docid;
        }

        $getter = $this->userRepository->getUserType($doctorId);

        if ($getter) {
            $userType = $getter->user_type;
        }

        $user->docid = $doctorId;
        $user->user_type = $userType;

        return $user;
    }
}
