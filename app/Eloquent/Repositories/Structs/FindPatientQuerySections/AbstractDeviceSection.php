<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections;

abstract class AbstractDeviceSection extends AbstractAdvanceOrderingSection
{
    public function getJoinSQL()
    {
        return <<<SQL
LEFT JOIN (
  SELECT patientid, dentaldevice, MAX(ex_page5id) AS max_id
  FROM dental_ex_page5
  GROUP BY patientid
) device_pivot ON device_pivot.patientid = p.patientid
LEFT JOIN dental_ex_page5 device_date ON device_date.ex_page5id = device_pivot.max_id
LEFT JOIN dental_device device ON device.deviceid = device_pivot.dentaldevice
SQL;
    }
}
