<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Services\AppointmentSummaries\UniqueTmjCreator;
use DentalSleepSolutions\Services\ClinicalExams\FlowDeviceUpdater;
use DentalSleepSolutions\Facades\ApiResponse;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TmjClinicalExamsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/tmj-clinical-exams",
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
     *                         @SWG\Items(ref="#/definitions/TmjClinicalExam")
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
     *     path="/tmj-clinical-exams/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/TmjClinicalExam")
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
     *     path="/tmj-clinical-exams",
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="palpationid", in="formData", type="string"),
     *     @SWG\Parameter(name="palpationRid", in="formData", type="string"),
     *     @SWG\Parameter(name="additional_paragraph_pal", in="formData", type="string"),
     *     @SWG\Parameter(name="joint_exam", in="formData", type="string"),
     *     @SWG\Parameter(name="jointid", in="formData", type="string"),
     *     @SWG\Parameter(name="i_opening_from", in="formData", type="string"),
     *     @SWG\Parameter(name="i_opening_to", in="formData", type="string"),
     *     @SWG\Parameter(name="i_opening_equal", in="formData", type="string"),
     *     @SWG\Parameter(name="protrusion_from", in="formData", type="string"),
     *     @SWG\Parameter(name="protrusion_to", in="formData", type="string"),
     *     @SWG\Parameter(name="protrusion_equal", in="formData", type="string"),
     *     @SWG\Parameter(name="l_lateral_from", in="formData", type="string"),
     *     @SWG\Parameter(name="l_lateral_to", in="formData", type="string"),
     *     @SWG\Parameter(name="l_lateral_equal", in="formData", type="string"),
     *     @SWG\Parameter(name="r_lateral_from", in="formData", type="string"),
     *     @SWG\Parameter(name="r_lateral_to", in="formData", type="string"),
     *     @SWG\Parameter(name="r_lateral_equal", in="formData", type="string"),
     *     @SWG\Parameter(name="deviation_from", in="formData", type="string"),
     *     @SWG\Parameter(name="deviation_to", in="formData", type="string"),
     *     @SWG\Parameter(name="deviation_equal", in="formData", type="string"),
     *     @SWG\Parameter(name="deflection_from", in="formData", type="string"),
     *     @SWG\Parameter(name="deflection_to", in="formData", type="string"),
     *     @SWG\Parameter(name="deflection_equal", in="formData", type="string"),
     *     @SWG\Parameter(name="range_normal", in="formData", type="string"),
     *     @SWG\Parameter(name="normal", in="formData", type="string"),
     *     @SWG\Parameter(name="other_range_motion", in="formData", type="string"),
     *     @SWG\Parameter(name="additional_paragraph_rm", in="formData", type="string"),
     *     @SWG\Parameter(name="screening_aware", in="formData", type="string"),
     *     @SWG\Parameter(name="screening_normal", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="deviation_r_l", in="formData", type="string"),
     *     @SWG\Parameter(name="deflection_r_l", in="formData", type="string"),
     *     @SWG\Parameter(name="dentaldevice", in="formData", type="integer"),
     *     @SWG\Parameter(name="dentaldevice_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/TmjClinicalExam")
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
     *     path="/tmj-clinical-exams/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="palpationid", in="formData", type="string"),
     *     @SWG\Parameter(name="palpationRid", in="formData", type="string"),
     *     @SWG\Parameter(name="additional_paragraph_pal", in="formData", type="string"),
     *     @SWG\Parameter(name="joint_exam", in="formData", type="string"),
     *     @SWG\Parameter(name="jointid", in="formData", type="string"),
     *     @SWG\Parameter(name="i_opening_from", in="formData", type="string"),
     *     @SWG\Parameter(name="i_opening_to", in="formData", type="string"),
     *     @SWG\Parameter(name="i_opening_equal", in="formData", type="string"),
     *     @SWG\Parameter(name="protrusion_from", in="formData", type="string"),
     *     @SWG\Parameter(name="protrusion_to", in="formData", type="string"),
     *     @SWG\Parameter(name="protrusion_equal", in="formData", type="string"),
     *     @SWG\Parameter(name="l_lateral_from", in="formData", type="string"),
     *     @SWG\Parameter(name="l_lateral_to", in="formData", type="string"),
     *     @SWG\Parameter(name="l_lateral_equal", in="formData", type="string"),
     *     @SWG\Parameter(name="r_lateral_from", in="formData", type="string"),
     *     @SWG\Parameter(name="r_lateral_to", in="formData", type="string"),
     *     @SWG\Parameter(name="r_lateral_equal", in="formData", type="string"),
     *     @SWG\Parameter(name="deviation_from", in="formData", type="string"),
     *     @SWG\Parameter(name="deviation_to", in="formData", type="string"),
     *     @SWG\Parameter(name="deviation_equal", in="formData", type="string"),
     *     @SWG\Parameter(name="deflection_from", in="formData", type="string"),
     *     @SWG\Parameter(name="deflection_to", in="formData", type="string"),
     *     @SWG\Parameter(name="deflection_equal", in="formData", type="string"),
     *     @SWG\Parameter(name="range_normal", in="formData", type="string"),
     *     @SWG\Parameter(name="normal", in="formData", type="string"),
     *     @SWG\Parameter(name="other_range_motion", in="formData", type="string"),
     *     @SWG\Parameter(name="additional_paragraph_rm", in="formData", type="string"),
     *     @SWG\Parameter(name="screening_aware", in="formData", type="string"),
     *     @SWG\Parameter(name="screening_normal", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="deviation_r_l", in="formData", type="string"),
     *     @SWG\Parameter(name="deflection_r_l", in="formData", type="string"),
     *     @SWG\Parameter(name="dentaldevice", in="formData", type="integer"),
     *     @SWG\Parameter(name="dentaldevice_date", in="formData", type="string", format="dateTime"),
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
     *     path="/tmj-clinical-exams/{id}",
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
     * @SWG\Put(
     *     path="/tmj-clinical-exams/update-flow-device/{deviceId}",
     *     tags={"tmj-clinical-exams"},
     *     summary="Update Flow Device",
     *     @SWG\Parameter(
     *         name="deviceId",
     *         in="path",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         required=true,
     *         type="integer"
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
     * @param int $deviceId
     * @param FlowDeviceUpdater $flowDeviceUpdater
     * @param Request $request
     * @return JsonResponse
     */
    public function updateFlowDevice(
        $deviceId,
        FlowDeviceUpdater $flowDeviceUpdater,
        Request $request
    ) {
        $patientId = $request->input('patient_id');

        try {
            $flowDeviceUpdater->update($this->user, $patientId, $deviceId);
        } catch (ValidatorException $e) {
            return ApiResponse::responseError($e->getMessage(), 422);
        }

        return ApiResponse::responseOk('Flow device was successfully updated.');
    }

    /**
     * @SWG\Post(
     *     path="/tmj-clinical-exams/store-for-patient",
     *     @SWG\Parameter(name="patient_id", in="query", type="integer", required=true),
     *     @SWG\Parameter(name="dentaldevice", in="query", type="string", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @param UniqueTmjCreator $uniqueTmjCreator
     * @return JsonResponse
     */
    public function storeForPatient(Request $request, UniqueTmjCreator $uniqueTmjCreator): JsonResponse
    {
        $patientId = (int)$request->input('patient_id');
        $device = (int)$request->input('dentaldevice');
        $resource = $uniqueTmjCreator->createUniqueTmj($this->user, $patientId, $device);
        $resource->save();
        return ApiResponse::responseOk('Resource created', $resource);
    }
}
