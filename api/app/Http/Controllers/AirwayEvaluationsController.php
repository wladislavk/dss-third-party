<?php

namespace DentalSleepSolutions\Http\Controllers;

/**
 * @todo: restore API tests if needed or delete the controller
 */
class AirwayEvaluationsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/airway-evaluations",
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
     *                         @SWG\Items(ref="#/definitions/AirwayEvaluation")
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
     *     path="/airway-evaluations/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/AirwayEvaluation")
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
     *     path="/airway-evaluations",
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="maxilla", in="formData", type="string", pattern="^~([0-9]~)+$"),
     *     @SWG\Parameter(name="other_maxilla", in="formData", type="string"),
     *     @SWG\Parameter(name="mandible", in="formData", type="string", pattern="^~([0-9]~)+$"),
     *     @SWG\Parameter(name="other_mandible", in="formData", type="string"),
     *     @SWG\Parameter(name="soft_palate", in="formData", type="string", pattern="^~([0-9]~)+$"),
     *     @SWG\Parameter(name="other_soft_palate", in="formData", type="string"),
     *     @SWG\Parameter(name="uvula", in="formData", type="string", pattern="^~([0-9]~)+$"),
     *     @SWG\Parameter(name="other_uvula", in="formData", type="string"),
     *     @SWG\Parameter(name="gag_reflex", in="formData", type="string", pattern="^~([0-9]~)+$"),
     *     @SWG\Parameter(name="other_gag_reflex", in="formData", type="string"),
     *     @SWG\Parameter(name="nasal_passages", in="formData", type="string", pattern="^~([0-9]~)+$"),
     *     @SWG\Parameter(name="other_nasal_passages", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/AirwayEvaluation")
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
     *     path="/airway-evaluations/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="maxilla", in="formData", type="string", pattern="^~([0-9]~)+$"),
     *     @SWG\Parameter(name="other_maxilla", in="formData", type="string"),
     *     @SWG\Parameter(name="mandible", in="formData", type="string", pattern="^~([0-9]~)+$"),
     *     @SWG\Parameter(name="other_mandible", in="formData", type="string"),
     *     @SWG\Parameter(name="soft_palate", in="formData", type="string", pattern="^~([0-9]~)+$"),
     *     @SWG\Parameter(name="other_soft_palate", in="formData", type="string"),
     *     @SWG\Parameter(name="uvula", in="formData", type="string", pattern="^~([0-9]~)+$"),
     *     @SWG\Parameter(name="other_uvula", in="formData", type="string"),
     *     @SWG\Parameter(name="gag_reflex", in="formData", type="string", pattern="^~([0-9]~)+$"),
     *     @SWG\Parameter(name="other_gag_reflex", in="formData", type="string"),
     *     @SWG\Parameter(name="nasal_passages", in="formData", type="string", pattern="^~([0-9]~)+$"),
     *     @SWG\Parameter(name="other_nasal_passages", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
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
     *     path="/airway-evaluations/{id}",
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
}
