<?php

namespace DentalSleepSolutions\Auth;

use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\Services\Auth\PasswordGenerator;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\Providers\Auth\Illuminate as IlluminateAuthAdapter;
use Illuminate\Contracts\Auth\Guard as GuardContract;

/**
 * This class is used as Authentication provider implementation
 * that replaces generic JWT class in order to depend on the
 * custom password hashing algo in the legacy code of DSS.
 *
 * @see self::check
 */
class LegacyAuth extends IlluminateAuthAdapter
{
    /** @var UserRepository */
    private $userRepository;

    /** @var PasswordGenerator */
    private $passwordGenerator;

    /**
     * @param GuardContract     $auth
     * @param UserRepository    $userRepository
     * @param PasswordGenerator $passwordGenerator
     */
    public function __construct(
        GuardContract $auth,
        UserRepository $userRepository,
        PasswordGenerator $passwordGenerator
    ) {
        parent::__construct($auth);

        $this->userRepository = $userRepository;
        $this->passwordGenerator = $passwordGenerator;
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
        return $this->passwordGenerator->verify($password, $user->password, $user->salt);
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
        $user = $this->userRepository->findByCredentials($credentials);
        if ($user && $this->check($user, $password)) {
            $this->auth->setUser($user);
            return true;
        }
        return false;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function byId($id)
    {
        $user = $this->userRepository->findById($id);
        if ($user) {
            $this->auth->setUser($user);
            return true;
        }
        return false;
    }
}
