<?php

namespace DentalSleepSolutions\Auth;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Auth\AuthManager;
use DentalSleepSolutions\Eloquent\User;
use Tymon\JWTAuth\Providers\Auth\IlluminateAuthAdapter;

/**
 * This class is used as Authentication provider implementation
 * that replaces generic JWT class in order to depend on the
 * custom password hashing algo in the legacy code of DSS.
 *
 * @see self::check
 */
class Legacy extends IlluminateAuthAdapter
{
    /**
     * Legacy-code hashed password validation.
     *
     * @param  \DentalSleepSolutions\Eloquent\User $user
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

        $user = User::where($credentials)->first();

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
     * @return mixed
     */
    public function byId ($id)
    {
        /**
         * Single ID
         */
        if (strpos($id, '|') === false) {
            return parent::byId($id);
        }

        /**
         * Wrong ID structure
         */
        if (!preg_match('/^(a_\d+[|]u_\d+|u_\d+[|]a_\d+)$/', $id)) {
            return false;
        }

        list($adminId, $userId) = explode('|', $id, 2);
        $admin = parent::byId($adminId);
        $user = parent::byId($userId);

        return $admin && $user ? [$admin, $user] : false;
    }
}
