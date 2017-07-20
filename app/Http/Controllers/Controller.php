<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Eloquent\User as UserView;
use DentalSleepSolutions\Contracts\Repositories\Users;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /** @var UserView|null */
    protected $currentAdmin;

    /** @var UserView|null */
    protected $currentUser;

    /** @var JWTAuth */
    protected $auth;

    public function __construct(
        JWTAuth $auth,
        Users $usersRepository
    ) {
        // TODO: see how it is possible to generate JWT token while testing
        if (env('APP_ENV') === 'testing') {
            $this->currentUser = new UserView();
            return;
        }

        $this->auth = $auth;
        $userInfo = $this->getUserInfo($auth, $usersRepository);

        $this->currentAdmin = $userInfo['admin'];
        $this->currentUser = $userInfo['user'];
    }

    /**
     * @param JWTAuth $auth
     * @param Users $usersRepository
     * @return UserView[]|null[]
     */
    private function getUserInfo(JWTAuth $auth, Users $usersRepository)
    {
        $userData = [
            'admin' => null,
            'user' => null
        ];

        $token = $auth->getToken();

        if (!$token) {
            return $userData;
        }

        $authUserData = $auth->toUser();

        if (!$userData) {
            return $userData;
        }

        if (!is_array($authUserData)) {
            $userData = [
                'admin' => $this->returnIfAdmin($authUserData),
                'user' => $this->returnIfUser($authUserData, $usersRepository),
            ];

            return $userData;
        }

        $userData = [
            'admin' => $this->filterAdmin($authUserData),
            'user' => $this->filterUser($authUserData, $usersRepository),
        ];

        return $userData;
    }

    /**
     * @param array $collection
     * @param Users $usersRepository
     * @return UserView|null
     */
    private function filterUser(array $collection, Users $usersRepository)
    {
        foreach ($collection as $each) {
            $user = $this->returnIfUser($each, $usersRepository);

            if ($user) {
                return $user;
            }
        }

        return null;
    }

    /**
     * @param array $collection
     * @return UserView|null
     */
    private function filterAdmin(array $collection)
    {
        foreach ($collection as $each) {
            $user = $this->returnIfAdmin($each);

            if ($user) {
                return $user;
            }
        }

        return null;
    }

    /**
     * @param UserView $user
     * @param Users $usersRepository
     * @return UserView|null
     */
    private function returnIfUser(UserView $user, Users $usersRepository)
    {
        $user = $this->returnIfModelType($user, UserView::USER_PREFIX);

        if (!$user) {
            return null;
        }

        $doctorId = $user->id;
        $userType = 0;

        $getter = $usersRepository->getDocId($user->id);

        if ($getter) {
            $doctorId = $getter->docid;
        }

        $getter = $usersRepository->getUserType($doctorId);

        if ($getter) {
            $userType = $getter->user_type;
        }

        $user->docid = $doctorId;
        $user->user_type = $userType;

        return $user;
    }

    /**
     * @param UserView $user
     * @return UserView|null
     */
    private function returnIfAdmin(UserView $user)
    {
        return $this->returnIfModelType($user, UserView::ADMIN_PREFIX);
    }

    /**
     * @param UserView $user
     * @param string   $modelPrefix
     * @return UserView|null
     */
    private function returnIfModelType(UserView $user, $modelPrefix)
    {
        $modelPrefix = preg_quote($modelPrefix);

        if (preg_match($user->id, "/^{$modelPrefix}(?P<id>\d+)$/", $matches)) {
            $user->id = $matches['id'];
            return $user;
        }

        return null;
    }
}
