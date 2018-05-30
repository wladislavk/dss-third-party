<?php

namespace DentalSleepSolutions\Auth;

use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Services\Auth\PasswordGenerator;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\UserProvider;

class Guard implements StatefulGuard
{
    use GuardHelpers;

    /** @var User */
    protected $user;

    /** @var UserProvider */
    protected $provider;

    /** @var PasswordGenerator */
    private $passwordGenerator;

    public function __construct(UserProvider $provider, PasswordGenerator $passwordGenerator)
    {
        $this->provider = $provider;
        $this->passwordGenerator = $passwordGenerator;
    }

    /**
     * @return Authenticatable|null
     */
    public function user(): ?Authenticatable
    {
        return $this->user;
    }

    /**
     * @param array $credentials
     * @return Authenticatable|null
     */
    public function once(array $credentials = []): ?Authenticatable
    {
        $this->user = $this->provider->retrieveByCredentials($credentials);
        $password = '';
        if (isset($credentials['password'])) {
            $password = $credentials['password'];
        }
        if (!$this->user) {
            return null;
        }
        $userPassword = '';
        if ($this->user->password) {
            $userPassword = $this->user->password;
        }
        if ($this->passwordGenerator->verify($password, $userPassword, $this->user->salt)) {
            return $this->user();
        }
        return $this->user();
    }

    /**
     * @param array $credentials
     * @param bool $remember
     * @param bool $login
     * @return Authenticatable|null
     */
    public function attempt(array $credentials = [], $remember = false, $login = true): ?Authenticatable
    {
        return $this->once($credentials);
    }

    /**
     * @param string $field
     * @return Authenticatable|null
     */
    public function basic($field = 'email'): ?Authenticatable
    {
        return null;
    }

    /**
     * @param string $field
     * @return Authenticatable|null
     */
    public function onceBasic($field = 'email'): ?Authenticatable
    {
        return null;
    }

    /**
     * @param array $credentials
     * @return Authenticatable|null
     */
    public function validate(array $credentials = []): ?Authenticatable
    {
        $this->user = $this->provider->retrieveByCredentials($credentials);
        if (!$this->user) {
            return null;
        }
        if (!isset($credentials['password'])) {
            return $this->user();
        }
        $password = $credentials['password'];
        $salt = '';
        if (!empty($this->user->salt)) {
            $salt = $this->user->salt;
        }
        if ($this->passwordGenerator->verify($password, $this->user->getAuthPassword(), $salt)) {
            return $this->user();
        }
        return null;
    }

    /**
     * @param Authenticatable $user
     * @param bool $remember
     * @return void
     */
    public function login(Authenticatable $user, $remember = false): void
    {
        $this->user = $user;
    }

    /**
     * @param int|string $id
     * @param bool $remember
     * @return Authenticatable|null
     */
    public function loginUsingId($id, $remember = false): ?Authenticatable
    {
        $this->user = $this->provider->retrieveById($id);
        return $this->user();
    }

    /**
     * @param int|string $id
     * @param bool $remember
     * @return Authenticatable|null
     */
    public function onceUsingId($id, $remember = false): ?Authenticatable
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
    public function logout(): void
    {
        // do nothing
    }
}
