<?php

namespace DentalSleepSolutions\Auth;

use Illuminate\Auth\AuthManager;
use Tymon\JWTAuth\Providers\Auth\IlluminateAuthAdapter;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Structs\CompositeId;
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
    const LOGIN_ID_SECTIONS = 2;

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
     * @return bool|array
     */
    public function byId($id)
    {
        /**
         * Single ID
         */
        if ($this->isSimpleId($id)) {
            return parent::byId($id);
        }

        if (!$this->isValidCompositeId($id)) {
            return false;
        }

        $compositeId = $this->decomposeId($id);
        $admin = parent::byId($compositeId->adminId);
        $user = parent::byId($compositeId->userId);

        if ($admin && $user) {
            return [$admin, $user];
        }

        return false;
    }

    /**
     * Check if the given id contains the delimiter
     *
     * @param string $id
     * @return bool
     */
    public function isSimpleId($id)
    {
        $isSimple = strpos($id, self::LOGIN_ID_DELIMITER) === false;
        return $isSimple;
    }

    /**
     * Check if the given id conforms to the composite id structure
     *
     * @param string $id
     * @return bool
     */
    public function isValidCompositeId($id)
    {
        $regexp = $this->compositeIdRegexp();

        if (preg_match($regexp, $id)) {
            return true;
        }

        return false;
    }

    /**
     * Join two ids using the id separator
     *
     * @param string $adminId
     * @param string $userId
     * @return string
     */
    public function composeId($adminId, $userId)
    {
        $compositeId = join(self::LOGIN_ID_DELIMITER, [$adminId, $userId]);
        return $compositeId;
    }

    /**
     * Parse the id and separate its components
     *
     * @param string $id
     * @return CompositeId
     */
    public function decomposeId($id)
    {
        $compositeId = new CompositeId();
        $compositeId->id = $id;

        $regexp = $this->compositeIdRegexp();

        if (preg_match($regexp, $id, $matches)) {
            $compositeId->adminId = $matches['adminId'];
            $compositeId->userId = $matches['userId'];
        }

        return $compositeId;
    }

    /**
     * @return string
     */
    private function compositeIdRegexp()
    {
        $adminPrefix = preg_quote(User::ADMIN_PREFIX);
        $userPrefix = preg_quote(User::USER_PREFIX);
        $delimiter = preg_quote(self::LOGIN_ID_DELIMITER);

        $regexp = "/^(?P<adminId>{$adminPrefix}\d+){$delimiter}(?P<userId>{$userPrefix}\d+)$/";
        return $regexp;
    }
}
