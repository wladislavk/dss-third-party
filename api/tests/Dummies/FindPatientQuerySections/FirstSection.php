<?php

namespace Tests\Dummies\FindPatientQuerySections;

use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\AbstractSection;

class FirstSection extends AbstractSection
{
    public function getSelectSQL()
    {
        return '';
    }

    public function getJoinSQL()
    {
        return '';
    }

    public function getOrderSQL($dir)
    {
        return '';
    }
}
