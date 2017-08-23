<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections;

class NameSection extends AbstractSection
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
        return "p.lastname $dir, p.firstname $dir";
    }
}
