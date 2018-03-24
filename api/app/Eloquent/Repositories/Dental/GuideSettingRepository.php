<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Database\Query\JoinClause;
use DB;

class GuideSettingRepository extends AbstractRepository
{
    public function model()
    {
        return GuideSetting::class;
    }

    /**
     * @param string $order
     * @return array
     */
    public function getAllOrderBy($order)
    {
        return $this->model->orderBy($order)->get();
    }

    /**
     * @param int $deviceId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getSettingType($deviceId)
    {
        return $this->model
            ->select('s.id', 's.setting_type', 'ds.value')
            ->from(DB::raw('dental_device_guide_settings s'))
            ->leftJoin(
                DB::raw('dental_device_guide_device_setting ds'),
                function (JoinClause $join) use ($deviceId) {
                    $join->on('s.id', '=', 'ds.setting_id')
                        ->where('ds.device_id', '=', $deviceId)
                    ;
                }
            )
            ->get()
        ;
    }
}
