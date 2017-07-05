<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\GuideSettings;
use Illuminate\Http\Request;

class GuideSettingsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/guide-settings",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/GuideSetting"))
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
     *     path="/guide-settings/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/GuideSetting"))
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
     *     path="/guide-settings",
     *     @SWG\Parameter(name="name", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="setting_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="range_start", in="formData", type="integer"),
     *     @SWG\Parameter(name="range_end", in="formData", type="integer"),
     *     @SWG\Parameter(name="rank", in="formData", type="integer"),
     *     @SWG\Parameter(name="options", in="formData", type="integer"),
     *     @SWG\Parameter(name="range_start_label", in="formData", type="string"),
     *     @SWG\Parameter(name="range_end_label", in="formData", type="string"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/GuideSetting"))
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
     *     path="/guide-settings/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="name", in="formData", type="string"),
     *     @SWG\Parameter(name="setting_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="range_start", in="formData", type="integer"),
     *     @SWG\Parameter(name="range_end", in="formData", type="integer"),
     *     @SWG\Parameter(name="rank", in="formData", type="integer"),
     *     @SWG\Parameter(name="options", in="formData", type="integer"),
     *     @SWG\Parameter(name="range_start_label", in="formData", type="string"),
     *     @SWG\Parameter(name="range_end_label", in="formData", type="string"),
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
     *     path="/guide-settings/{id}",
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

    public function getAllOrderBy(GuideSettings $resources, Request $request)
    {
        $order = $request->input('order', 'name');

        $guideSettings = $resources->getAllOrderBy($order);

        return ApiResponse::responseOk('', $guideSettings);
    }
}
