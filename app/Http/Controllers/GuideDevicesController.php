<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\Request;

class GuideDevicesController extends BaseRestController
{
    public function index()
    {
        return parent::index();
    }

    public function show($id)
    {
        return parent::show($id);
    }

    public function store()
    {
        return parent::store();
    }

    public function update($id)
    {
        return parent::update($id);
    }

    public function destroy($id)
    {
        return parent::destroy($id);
    }

    public function getWithImages(Device $devicesResource, GuideSetting $guideSettingsResource, Request $request)
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
