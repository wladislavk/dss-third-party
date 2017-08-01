<?php

namespace DentalSleepSolutions\Auth;

use Illuminate\Auth\AuthManager;
use Tymon\JWTAuth\Providers\Auth\IlluminateAuthAdapter;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\StaticClasses\SudoHelper;
use Illuminate\Support\Arr;

/**
 * This class is used as Authentication provider implementation
 * that replaces generic JWT class in order to depend on the
 * custom password hashing algo in the legacy code of DSS.
 *
 * @see self::check
 */
class Legacy extends IlluminateAuthAdapter
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(
        AuthManager $auth,
        UserRepository $userRepository
    )
    {
        parent::__construct($auth);
        $this->userRepository = $userRepository;
    }

    /**
     * Legacy-code hashed password validation.
     *
     * @param User $user
     * @param string $password
     * @return boolean
     */
    protected function check(User $user, $password)
    {
        return $user->password === $this->hashPassword($password, $user->salt);
    }

    /**
     * Check a user's credentials
     *
     * @param  array  $credentials
     * @return boolean
     */
    public function byCredentials(array $credentials = [])
    {
        $password = Arr::pull($credentials, 'password');

        $user = $this->userRepository->findWhere($credentials)->first();

        if ($user && $this->check($user, $password)) {
            $this->auth->login($user, false);

            return true;
        }

        return false;
    }

    /**
     * Check user ID. DSS can use a composite ID, to log in an admin AND some user, "login as" behavior
     *
     * @param mixed $id
     * @return bool|array
     */
    public function byId($id)
    {
        /**
         * Single ID
         */
        if (SudoHelper::isSimpleId($id)) {
            return parent::byId($id);
        }

        if (!SudoHelper::isSudoId($id)) {
            return false;
        }

        $sudoId = SudoHelper::parseId($id);
        $admin = parent::byId($sudoId->adminId);
        $user = parent::byId($sudoId->userId);

        if ($admin && $user) {
            return [$admin, $user];
        }

        return false;
    }

    /**
     * @param string $password
     * @param string $salt
     * @return string
     */
    public function hashPassword($password, $salt)
    {
        return hash('sha256', $password . $salt);
    }
}
