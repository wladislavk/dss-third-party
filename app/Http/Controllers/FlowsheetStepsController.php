<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\FlowsheetStepRepository;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Helpers\TrackerStepRetriever;

class FlowsheetStepsController extends BaseRestController
{
    /** @var FlowsheetStepRepository */
    protected $repository;

    /**
     * @SWG\Get(
     *     path="/flowsheet-steps",
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
     *                         @SWG\Items(ref="#/definitions/FlowsheetStep")
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
     *     path="/flowsheet-steps/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/FlowsheetStep")
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
     *     path="/flowsheet-steps",
     *     @SWG\Parameter(name="name", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="sort_by", in="formData", type="integer"),
     *     @SWG\Parameter(name="section", in="formData", type="integer", required=true),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/FlowsheetStep")
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
     *     path="/flowsheet-steps/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="name", in="formData", type="string"),
     *     @SWG\Parameter(name="sort_by", in="formData", type="integer"),
     *     @SWG\Parameter(name="section", in="formData", type="integer"),
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
     *     path="/flowsheet-steps/{id}",
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
     *     path="/flowsheet-steps/by-section",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param TrackerStepRetriever $trackerStepRetriever
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBySection(TrackerStepRetriever $trackerStepRetriever)
    {
        $steps = $trackerStepRetriever->getRanksBySection();
        return ApiResponse::responseOk('', $steps);
    }

    /**
     * @SWG\Get(
     *     path="/flowsheet-steps/by-next-step/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByNextStep($id)
    {
        $steps = $this->repository->getStepsByNext($id);
        return ApiResponse::responseOk('', $steps);
    }
}
