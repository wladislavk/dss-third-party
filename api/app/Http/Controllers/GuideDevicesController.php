<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Services\DeviceGuides\DeviceGuideResultsRetriever;
use DentalSleepSolutions\Facades\ApiResponse;
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
     * @SWG\Get(
     *     path="/guide-devices/with-images",
     *     tags={"guide-devices"},
     *     summary="Get Device Guide results with images",
     *     @SWG\Parameter(
     *         name="impressions",
     *         in="query",
     *         required=false,
     *         type="array"
     *     ),
     *     @SWG\Parameter(
     *         name="options",
     *         in="query",
     *         required=false,
     *         type="array"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="success"
     *     )
     *     @SWG\Response(
     *         response="default",
     *         description="error",
     *         ref="#/responses/error_response"
     *     )
     * )
     *
     * @param DeviceGuideResultsRetriever $deviceGuideResultsRetriever
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithImages(
        DeviceGuideResultsRetriever $deviceGuideResultsRetriever,
        Request $request
    ) {
        $impressions = $request->input('impressions', []);
        $impressions = array_map(function ($TElement) {
            return (bool)$TElement;
        }, $impressions);
        $checkedOptions = $request->input('options', []);
        $checkedOptions = array_map(function ($TElement) {
            return (bool)$TElement;
        }, $checkedOptions);
        $devicesArray = $deviceGuideResultsRetriever->getDeviceGuides($impressions, $checkedOptions);

        return ApiResponse::responseOk('', $devicesArray);
    }
}
