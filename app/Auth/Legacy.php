<?php

namespace DentalSleepSolutions\Auth;

use Illuminate\Auth\AuthManager;
use Tymon\JWTAuth\Providers\Auth\IlluminateAuthAdapter;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\Eloquent\Models\User;
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
    const LOGIN_ID_DELIMITER = '|';

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
     * @param  string $password
     * @return boolean
     */
    protected function check($user, $password)
    {
        return $user->password === hash('sha256', $password . $user->salt);
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

        $user = $this->userRepository->where($credentials)->first();

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
     * @return bool|User[]
     */
    public function byId($id)
    {
        /**
         * Single ID
         */
        if (strpos($id, self::LOGIN_ID_DELIMITER) === false) {
            return parent::byId($id);
        }

        /**
         * Wrong ID structure
         */
        $adminPrefix = preg_quote(User::ADMIN_PREFIX);
        $userPrefix = preg_quote(User::USER_PREFIX);
        $delimiter = preg_quote(self::LOGIN_ID_DELIMITER);

        if (!preg_match("/^{$adminPrefix}\d+{$delimiter}{$userPrefix}\d+$/", $id)) {
            return false;
        }

        list($adminId, $userId) = explode(self::LOGIN_ID_DELIMITER, $id, 2);
        $admin = parent::byId($adminId);
        $user = parent::byId($userId);

        if ($admin && $user) {
            return [$admin, $user];
        }

        return false;
    }
}
