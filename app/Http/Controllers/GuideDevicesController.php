<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\Devices;
use DentalSleepSolutions\Contracts\Repositories\GuideSettings;
use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Http\Requests\AbstractDestroyRequest;
use DentalSleepSolutions\Http\Requests\AbstractStoreRequest;
use DentalSleepSolutions\Http\Requests\AbstractUpdateRequest;
use Illuminate\Http\Request;

class GuideDevicesController extends Controller
{
    public function index(Repository $resources)
    {
        return parent::index($resources);
    }

    public function show(Resource $resource)
    {
        return parent::show($resource);
    }

    public function store(Repository $resources, AbstractStoreRequest $request)
    {
        return parent::store($resources, $request);
    }

    public function update(Resource $resource, AbstractUpdateRequest $request)
    {
        return parent::update($resource, $request);
    }

    public function destroy(Resource $resource, AbstractDestroyRequest $request)
    {
        return parent::destroy($resource, $request);
    }

    public function getWithImages(Devices $devicesResource, GuideSettings $guideSettingsResource, Request $request)
    {
        $settings = $request->input('settings');

        $fields = ['deviceid', 'device', 'image_path'];
        $devices = $devicesResource->getWithFilter($fields);
        $devicesArray = [];

        if (count($devices)) {
            foreach ($devices as $device) {
                $total = 0;
                $show  = true;

                $guideSettings = $guideSettingsResource->getSettingType($device->deviceid);

                if (count($guideSettings)) {
                    foreach ($guideSettings as $guideSetting) {
                        if (empty($settings[$guideSetting->id])) {
                            continue;
                        }
                        $setting = $settings[$guideSetting->id];

                        if ($guideSetting->setting_type == 1) {
                            if ($guideSetting->value != '1' && $setting['checked'] == 1) {
                                $show = false;
                            }
                        } else {
                            $value = $setting['checked'] * $guideSetting->value;

                            if (isset($setting['checkedImp'])) {
                                $value *= 1.75;
                            }

                            $total += $value;
                        }
                    }
                }

                if ($show) {
                    array_push($devicesArray, [
                        'name'       => $device->device,
                        'id'         => $device->deviceid,
                        'value'      => $total,
                        'imagePath'  => $device->image_path,
                    ]);
                }
            }
        }

        usort($devicesArray, [$this, 'sortDevices']);

        return ApiResponse::responseOk('', $devicesArray);
    }

    private function sortDevices($firstElement, $secondElement)
    {
        if ($firstElement['value'] == $secondElement['value']) {
            return 0;
        }

        return ($firstElement['value'] > $secondElement['value']) ? -1 : 1;
    }
}
