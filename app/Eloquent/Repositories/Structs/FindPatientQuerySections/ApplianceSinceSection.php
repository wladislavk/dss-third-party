<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections;

class ApplianceSinceSection extends AbstractDeviceSection
{
    public function getSelectSQL()
    {
        return <<<SQL
device_date.dentaldevice_date AS dentaldevice_date
SQL;
    }

    protected function getInnerOrderSQL($dir)
    {
        return <<<SQL
dentaldevice_date $dir
SQL;
    }
}
