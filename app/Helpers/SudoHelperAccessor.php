<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\StaticClasses\SudoHelper;
use DentalSleepSolutions\Structs\SudoId;

class SudoHelperAccessor
{
    public function isSimpleId($id)
    {
        return SudoHelper::isSimpleId($id);
    }

    /**
     * Check if the given id conforms to the composite id structure
     *
     * @param string $id
     * @return bool
     */
    public function isSudoId($id)
    {
        return SudoHelper::isSudoId($id);
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
        return SudoHelper::sudoId($adminId, $userId);
    }

    /**
     * Parse the id and separate its components
     *
     * @param string $id
     * @return SudoId
     */
    public function parseId($id)
    {
        return SudoHelper::parseId($id);
    }
}
