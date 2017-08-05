<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Structs\SudoId;

class SudoHelper
{
    const LOGIN_ID_DELIMITER = '|';
    const LOGIN_ID_SECTIONS = 2;
    const ADMIN_PREFIX = 'a_';
    const USER_PREFIX = 'u_';

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
    public function isSudoId($id)
    {
        $regexp = $this->sudoIdRegexp();

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
    public function sudoId($adminId, $userId)
    {
        $sudoId = join(self::LOGIN_ID_DELIMITER, [$adminId, $userId]);
        return $sudoId;
    }

    /**
     * Parse the id and separate its components
     *
     * @param string $id
     * @return SudoId
     */
    public function parseId($id)
    {
        $sudoId = new SudoId();
        $sudoId->id = $id;

        $regexp = $this->sudoIdRegexp();
        preg_match($regexp, $id, $matches);

        if (isset($matches['adminId'])) {
            $sudoId->adminId = $matches['adminId'];
        }

        if (isset($matches['userId'])) {
            $sudoId->userId = $matches['userId'];
        }

        return $sudoId;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function isUid($id)
    {
        return $this->isOfType($id, self::USER_PREFIX);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function isAid($id)
    {
        return $this->isOfType($id, self::ADMIN_PREFIX);
    }

    /**
     * @param string|int $id
     * @param string $prefix
     * @return bool
     */
    private function isOfType($id, $prefix)
    {
        $regexp = $this->idTypeRegexp($prefix);

        if (preg_match("/^{$regexp}$/", $id)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    private function sudoIdRegexp()
    {
        $adminPrefix = $this->idTypeRegexp(self::ADMIN_PREFIX);
        $userPrefix = $this->idTypeRegexp(self::USER_PREFIX);
        $delimiter = preg_quote(self::LOGIN_ID_DELIMITER);

        $regexp = "/^(?P<adminId>{$adminPrefix}){$delimiter}(?P<userId>{$userPrefix})$/";
        return $regexp;
    }

    /**
     * @param string $prefix
     * @return string
     */
    private function idTypeRegexp($prefix)
    {
        $prefix = preg_quote($prefix);
        $regexp = "{$prefix}\d+";

        return $regexp;
    }
}
