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
}
