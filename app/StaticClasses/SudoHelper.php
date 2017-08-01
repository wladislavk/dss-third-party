<?php

namespace DentalSleepSolutions\StaticClasses;

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
    public static function isSimpleId($id)
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
    public static function isSudoId($id)
    {
        $regexp = self::sudoIdRegexp();

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
    public static function sudoId($adminId, $userId)
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
    public static function parseId($id)
    {
        $sudoId = new SudoId();
        $sudoId->id = $id;

        $regexp = self::sudoIdRegexp();
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
     * @return string
     */
    private static function sudoIdRegexp()
    {
        $adminPrefix = preg_quote(self::ADMIN_PREFIX);
        $userPrefix = preg_quote(self::USER_PREFIX);
        $delimiter = preg_quote(self::LOGIN_ID_DELIMITER);

        $regexp = "/^(?P<adminId>{$adminPrefix}\d+){$delimiter}(?P<userId>{$userPrefix}\d+)$/";
        return $regexp;
    }
}
