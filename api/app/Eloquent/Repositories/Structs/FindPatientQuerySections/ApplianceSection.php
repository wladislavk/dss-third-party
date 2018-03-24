<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections;

class ApplianceSection extends AbstractDeviceSection
{
    public function getSelectSQL()
    {
        return <<<SQL
device.device AS device
SQL;
    }

    protected function getInnerOrderSQL($dir)
    {
        return <<<SQL
device $dir
SQL;
    }
}
