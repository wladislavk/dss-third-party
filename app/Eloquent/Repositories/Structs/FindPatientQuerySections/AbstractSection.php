<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections;

abstract class AbstractSection
{
    /**
     * @return string
     */
    abstract public function getSelectSQL();

    /**
     * @return string
     */
    abstract public function getJoinSQL();

    /**
     * @param string $dir
     * @return string
     */
    abstract public function getOrderSQL($dir);
}
