<?php

namespace DentalSleepSolutions\Http\Controllers;

class PlansController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/plans",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/Plan"))
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
     *     path="/plans/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Plan"))
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
     *     path="/plans",
     *     @SWG\Parameter(name="name", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="monthly_fee", in="formData", type="string", required=true, pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="trial_period", in="formData", type="integer"),
     *     @SWG\Parameter(name="fax_fee", in="formData", type="string", required=true, pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="free_fax", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="eligibility_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="free_eligibility", in="formData", type="integer"),
     *     @SWG\Parameter(name="enrollment_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="free_enrollment", in="formData", type="integer"),
     *     @SWG\Parameter(name="claim_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="free_claim", in="formData", type="integer"),
     *     @SWG\Parameter(name="vob_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="free_vob", in="formData", type="integer"),
     *     @SWG\Parameter(name="office_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="efile_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="free_efile", in="formData", type="integer"),
     *     @SWG\Parameter(name="duration", in="formData", type="integer"),
     *     @SWG\Parameter(name="producer_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="user_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="patient_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="e0486_bill", in="formData", type="integer"),
     *     @SWG\Parameter(name="e0486_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Plan"))
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
     *     path="/plans/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="name", in="formData", type="string"),
     *     @SWG\Parameter(name="monthly_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="trial_period", in="formData", type="integer"),
     *     @SWG\Parameter(name="fax_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="free_fax", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="eligibility_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="free_eligibility", in="formData", type="integer"),
     *     @SWG\Parameter(name="enrollment_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="free_enrollment", in="formData", type="integer"),
     *     @SWG\Parameter(name="claim_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="free_claim", in="formData", type="integer"),
     *     @SWG\Parameter(name="vob_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="free_vob", in="formData", type="integer"),
     *     @SWG\Parameter(name="office_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="efile_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="free_efile", in="formData", type="integer"),
     *     @SWG\Parameter(name="duration", in="formData", type="integer"),
     *     @SWG\Parameter(name="producer_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="user_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="patient_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="e0486_bill", in="formData", type="integer"),
     *     @SWG\Parameter(name="e0486_fee", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
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
     *     path="/plans/{id}",
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
