<?php

namespace DentalSleepSolutions\Services\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\UserProvider;

class Guard implements StatefulGuard
{
    use GuardHelpers;

    public function __construct(UserProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return Authenticatable|null
     */
    public function user():? Authenticatable
    {
        return $this->user;
    }

    /**
     * @param array $credentials
     * @return Authenticatable|null
     */
    public function once(array $credentials = []):? Authenticatable
    {
        $this->user = $this->provider->retrieveByCredentials($credentials);
        return $this->user();
    }

    /**
     * @param array $credentials
     * @param bool $remember
     * @param bool $login
     * @return Authenticatable|null
     */
    public function attempt(array $credentials = [], $remember = false, $login = true):? Authenticatable
    {
        return $this->once($credentials);
    }

    /**
     * @param string $field
     * @return Authenticatable|null
     */
    public function basic($field = 'email'):? Authenticatable
    {
        return null;
    }

    /**
     * @param string $field
     * @return Authenticatable|null
     */
    public function onceBasic($field = 'email'):? Authenticatable
    {
        return null;
    }

    /**
     * @param array $credentials
     * @return Authenticatable|null
     */
    public function validate(array $credentials = []):? Authenticatable
    {
        $this->user = $this->provider->retrieveByCredentials($credentials);
        return $this->user();
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
    public function loginUsingId($id, $remember = false):? Authenticatable
    {
        $this->user = $this->provider->retrieveById($id);
        return $this->user();
    }

    /**
     * @param int|string $id
     * @param bool $remember
     * @return Authenticatable|null
     */
    public function onceUsingId($id, $remember = false):? Authenticatable
    {
        $this->user = $this->provider->retrieveById($id);
        return $this->user();
    }

    /**
     * @return bool
     */
    public function viaRemember(): bool
    {
        return false;
    }

    /**
     * @return void
     */
    public function logout()
    {

    }
}
