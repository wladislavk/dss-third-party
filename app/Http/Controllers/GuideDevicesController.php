<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingRepository;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\Request;

class GuideDevicesController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/guide-devices",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/GuideDevice")
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function index()
    {
        return parent::index();
    }

    /**
     * @SWG\Get(
     *     path="/guide-devices/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/GuideDevice")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function show($id)
    {
        return parent::show($id);
    }

    /**
     * @SWG\Post(
     *     path="/guide-devices",
     *     @SWG\Parameter(name="name", in="formData", type="string", required=true),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/GuideDevice")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function store()
    {
        return parent::store();
    }

    /**
     * @SWG\Put(
     *     path="/guide-devices/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="name", in="formData", type="string", required=true),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function update($id)
    {
        return parent::update($id);
    }

    /**
     * @SWG\Delete(
     *     path="/guide-devices/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="Resource deleted", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function destroy($id)
    {
        return parent::destroy($id);
    }

    /**
     * @SWG\Post(
     *     path="/guide-devices/with-images",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Device $devicesResource
     * @param GuideSettingRepository $guideSettingRepository
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithImages(
        Device $devicesResource,
        GuideSettingRepository $guideSettingRepository,
        Request $request
    ) {
        $settings = $request->input('settings');

        $fields = ['deviceid', 'device', 'image_path'];
        $devices = $devicesResource->getWithFilter($fields);
        $devicesArray = [];

        if (count($devices)) {
            foreach ($devices as $device) {
                $total = 0;
                $show  = true;

                $guideSettings = $guideSettingRepository->getSettingType($device->deviceid);

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
