<?php

namespace DentalSleepSolutions\Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\StaticClasses\ApiResponse;

abstract class AbstractGuard implements Guard
{
    /** @var array */
    protected $enforceCredentials = [];

    /** @var UserRepository */
    protected $userRepository;

    /** @var User */
    protected $user;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return bool
     */
    public function check()
    {
        return !is_null($this->user());
    }

    /**
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * @return Authenticatable|null
     */
    public function user()
    {
        if ($this->user) {
            return $this->user;
        }

        return null;
    }

    /**
     * @param array $credentials
     * @return bool
     */
    public function once(array $credentials = [])
    {
        $user = $this->userByCredentials($credentials);

        if ($user) {
            $this->user = $user;
            return true;
        }

        return false;
    }

    /**
     * @param array $credentials
     * @param bool $remember
     * @param bool $login
     * @return bool
     */
    public function attempt(array $credentials = [], $remember = false, $login = true)
    {
        return $this->once($credentials);
    }

    /**
     * @param string $field
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function basic($field = 'email')
    {
        return ApiResponse::responseError('Invalid Auth Method', 400);
    }

    /**
     * @param string $field
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function onceBasic($field = 'email')
    {
        return ApiResponse::responseError('Invalid Auth Method', 400);
    }

    /**
     * @param array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $user = $this->userByCredentials($credentials);

        if ($user) {
            return true;
        }

        return false;
    }

    /**
     * @param Authenticatable $user
     * @param bool $remember
     * @return void
     */
    public function login(Authenticatable $user, $remember = false)
    {
        $this->user = $user;
    }

    /**
     * @param int|string $id
     * @param bool $remember
     * @return Authenticatable|null
     */
    public function loginUsingId($id, $remember = false)
    {
        $user = $this->userByCredentials(['id' => $id]);

        if ($user) {
            $this->user = $user;
            return $user;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function viaRemember()
    {
        return false;
    }

    /**
     * @return void
     */
    public function logout()
    {

    }

    /**
     * @param array $credentials
     * @return Authenticatable|null
     */
    protected function userByCredentials(array $credentials)
    {
        $verifyPassword = false;
        $password = '';

        if (isset($credentials['password'])) {
            $verifyPassword = true;
            $password = $credentials['password'];
            unset($credentials['password']);
        }

        $user = $this->userRepository
            ->findWhere($credentials)
            ->first()
        ;

        if (!$user) {
            return null;
        }

        if ($verifyPassword) {
            $hash = hash('sha256', $password . $user->salt);

            if ($hash !== $user->password) {
                return null;
            }
        }

        if (!$this->enforceCredentials) {
            return $user;
        }

        foreach ($this->enforceCredentials as $field=>$value) {
            if ($user->{$field} !== $value) {
                return null;
            }
        }

        return $user;
    }
}
