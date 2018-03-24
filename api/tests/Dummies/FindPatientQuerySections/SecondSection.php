<?php

namespace Tests\Dummies\FindPatientQuerySections;

use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\AbstractSection;

class SecondSection extends AbstractSection
{
    public function getSelectSQL()
    {
        return '%COLUMN% select SQL';
    }

    public function getJoinSQL()
    {
        return 'join SQL';
    }

    public function getOrderSQL($dir)
    {
        return "order SQL $dir";
    }
}
