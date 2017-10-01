<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Screener;
use DentalSleepSolutions\Eloquent\Models\Dental\ScreenerEpworth;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ScreenerRepository extends AbstractRepository
{
    public function model()
    {
        return Screener::class;
    }

    /**
     * @param array $data
     * @param array[] $epworthData
     * @return Screener
     */
    public function createWithEpworth(array $data, array $epworthData)
    {
        /** @var Screener $screener */
        $screener = $this->create($data);
        foreach ($epworthData as $epworthElement) {
            $epworthRecord = new ScreenerEpworth();
            $epworthRecord->screener_id = $screener->id;
            $epworthRecord->epworth_id = $epworthElement['epworthid'];
            $epworthRecord->response = $epworthElement['selected'];
            $epworthRecord->adddate = $screener->adddate;
            $epworthRecord->ip_address = $screener->ip_address;
            $epworthRecord->save();
        }
        return $screener;
    }
}
