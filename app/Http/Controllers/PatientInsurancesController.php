<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\PatientInsurances;
use Illuminate\Http\Request;

class PatientInsurancesController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/patient-insurances",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/PatientInsurance"))
     *                 )
     *             )
     *         }
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
     *     path="/patient-insurances/{patient_insurances}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/PatientInsurance"))
     *             )
     *         }
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
     *     path="/patient-insurances",
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="insurancetype", in="formData", type="integer"),
     *     @SWG\Parameter(name="company", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="address1", in="formData", type="string"),
     *     @SWG\Parameter(name="address2", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string"),
     *     @SWG\Parameter(name="state", in="formData", type="string"),
     *     @SWG\Parameter(name="zip", in="formData", type="string", pattern="[0-9]{5}"),
     *     @SWG\Parameter(name="phone", in="formData", type="string", pattern="[0-9]{10}"),
     *     @SWG\Parameter(name="fax", in="formData", type="string"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/PatientInsurance"))
     *             )
     *         }
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function store()
    {
        $this->hasIp = false;
        return parent::store();
    }

    /**
     * @SWG\Put(
     *     path="/patient-insurances/{patient_insurances}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="insurancetype", in="formData", type="integer"),
     *     @SWG\Parameter(name="company", in="formData", type="string"),
     *     @SWG\Parameter(name="address1", in="formData", type="string"),
     *     @SWG\Parameter(name="address2", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string"),
     *     @SWG\Parameter(name="state", in="formData", type="string"),
     *     @SWG\Parameter(name="zip", in="formData", type="string", pattern="[0-9]{5}"),
     *     @SWG\Parameter(name="phone", in="formData", type="string", pattern="[0-9]{10}"),
     *     @SWG\Parameter(name="fax", in="formData", type="string"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email"),
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
     *     path="/patient-insurances/{patient_insurances}",
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

    public function getCurrent(PatientInsurances $resources, Request $request)
    {
        $patientId = $request->input('patientId', 0);
        $docId     = $this->currentUser->docid ?: 0;

        $data = $resources->getCurrent($docId, $patientId);

        return ApiResponse::responseOk('', $data);
    }

    public function getNumber(PatientInsurances $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getNumber($docId);

        return ApiResponse::responseOk('', $data);
    }
}
