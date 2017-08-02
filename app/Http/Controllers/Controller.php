<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Helpers\SudoHelper;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Config\Repository as Config;
use DentalSleepSolutions\Eloquent\Models\User;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    // TODO: this class should include common REST methods for all its children

    use DispatchesJobs, ValidatesRequests;

    /** @var User|null */
    protected $currentAdmin;

    /** @var User|null */
    protected $currentUser;

    /** @var JWTAuth */
    protected $auth;

    public function __construct(
        JWTAuth $auth,
        UserRepository $userRepository,
        Config $config
    ) {
        // TODO: see how it is possible to generate JWT token while testing
        if ($config->get('app.env') === 'testing') {
            $this->currentUser = new User();
            $this->currentAdmin = new User();
            $this->currentUser->id = 0;
            $this->currentAdmin->id = 0;

            return;
        }

        $this->auth = $auth;
        $userInfo = $this->getUserInfo($auth, $userRepository);

        $this->currentAdmin = $userInfo['admin'];
        $this->currentUser = $userInfo['user'];
    }

    /**
     * @param JWTAuth $auth
     * @param UserRepository $userRepository
     * @return mixed
     */
    private function getUserInfo(JWTAuth $auth, UserRepository $userRepository)
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

        if (!$authUserData) {
            return null;
        }

        if (!is_array($authUserData)) {
            $userData = [
                'admin' => $this->returnIfAdmin($authUserData),
                'user' => $this->returnIfUser($authUserData, $userRepository),
            ];

            return $userData;
        }

        $userData = [
            'admin' => $this->filterAdmin($authUserData),
            'user' => $this->filterUser($authUserData, $userRepository),
        ];

        return $userData;
    }

    /**
     * @param array $collection
     * @param UserRepository $userRepository
     * @return User|null
     */
    private function filterUser(array $collection, UserRepository $userRepository)
    {
        foreach ($collection as $each) {
            $user = $this->returnIfUser($each, $userRepository);

            if ($user) {
                return $user;
            }
        }

        return null;
    }

    /**
     * @param array $collection
     * @return User|null
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
     * @param User $user
     * @param UserRepository $userRepository
     * @return User|null
     */
    private function returnIfUser(User $user, UserRepository $userRepository)
    {
        $user = $this->returnIfModelType($user, SudoHelper::USER_PREFIX);

        if (!$user) {
            return null;
        }

        $doctorId = $user->id;
        $userType = 0;

        $getter = $userRepository->getDocId($user->id);

        if ($getter) {
            $doctorId = $getter->docid;
        }

        $getter = $userRepository->getUserType($doctorId);

        if ($getter) {
            $userType = $getter->user_type;
        }

        $user->docid = $doctorId;
        $user->user_type = $userType;

        return $user;
    }

    /**
     * @param User $user
     * @return User|null
     */
    private function returnIfAdmin(User $user)
    {
        return $this->returnIfModelType($user, SudoHelper::ADMIN_PREFIX);
    }

    /**
     * @param User   $user
     * @param string $modelPrefix
     * @return User|null
     */
    private function returnIfModelType(User $user, $modelPrefix)
    {
        $modelPrefix = preg_quote($modelPrefix);

        if (preg_match("/^{$modelPrefix}(?P<id>\d+)$/", $user->id, $matches)) {
            $user->id = $matches['id'];
            return $user;
        }

        return null;
    }
}
