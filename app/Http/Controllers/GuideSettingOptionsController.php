<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingOptionRepository;
use DentalSleepSolutions\Helpers\GuideSettingOptionsRetriever;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Facades\ApiResponse;

class GuideSettingOptionsController extends BaseRestController
{
    /** @var GuideSettingOptionRepository */
    protected $repository;

    /**
     * @SWG\Get(
     *     path="/guide-setting-options",
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
     *                         @SWG\Items(ref="#/definitions/GuideSettingOption")
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
     *     path="/guide-setting-options/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/GuideSettingOption")
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
     *     path="/guide-setting-options",
     *     @SWG\Parameter(name="option_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="setting_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="label", in="formData", type="string", required=true),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/GuideSettingOption")
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
     *     path="/guide-setting-options/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="option_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="setting_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="label", in="formData", type="string"),
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
     *     path="/guide-setting-options/{id}",
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
     *     path="/guide-setting-options/settingIds",
     *     @SWG\Response(response="200", description="Get Device Guide Setting options")
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOptionsForSettingIds(GuideSettingOptionsRetriever $guideSettingOptionsRetriever)
    {
        try {
            $guideSettingOptions = $guideSettingOptionsRetriever->get();
        } catch (GeneralException $e) {
            return ApiResponse::responseError($e->getMessage(), 422);
        }

        return ApiResponse::responseOk('', $guideSettingOptions);
    }
}
