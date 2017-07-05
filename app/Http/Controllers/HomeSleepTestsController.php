<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\HomeSleepTests;
use Illuminate\Http\Request;

class HomeSleepTestsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/home-sleep-tests",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/HomeSleepTest"))
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
     *     path="/home-sleep-tests/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/HomeSleepTest"))
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
     *     path="/home-sleep-tests",
     *     @SWG\Parameter(name="doc_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="user_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="company_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="patient_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="screener_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="ins_co_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="ins_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="patient_ins_group_id", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_ins_id", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_firstname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="patient_lastname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="patient_add1", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_add2", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_city", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_state", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="patient_dob", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_cell_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="patient_home_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="patient_email", in="formData", type="string", format="email"),
     *     @SWG\Parameter(name="diagnosis_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="hst_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="provider_firstname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="provider_lastname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="provider_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="provider_address", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_city", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_state", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="provider_signature", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_date", in="formData", type="string"),
     *     @SWG\Parameter(name="snore_1", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_2", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_3", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_4", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_5", in="formData", type="integer"),
     *     @SWG\Parameter(name="viewed", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="office_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_study_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="authorized_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="authorizeddate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="updatedate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="rejected_reason", in="formData", type="string"),
     *     @SWG\Parameter(name="rejecteddate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="canceled_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="canceled_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="hst_nights", in="formData", type="integer"),
     *     @SWG\Parameter(name="hst_positions", in="formData", type="string"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/HomeSleepTest"))
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
     *     path="/home-sleep-tests/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="doc_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="user_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="company_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="patient_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="screener_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="ins_co_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="ins_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="patient_ins_group_id", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_ins_id", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_firstname", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_lastname", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_add1", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_add2", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_city", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_state", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="patient_dob", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_cell_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="patient_home_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="patient_email", in="formData", type="string", format="email"),
     *     @SWG\Parameter(name="diagnosis_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="hst_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="provider_firstname", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_lastname", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="provider_address", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_city", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_state", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="provider_signature", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_date", in="formData", type="string"),
     *     @SWG\Parameter(name="snore_1", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_2", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_3", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_4", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_5", in="formData", type="integer"),
     *     @SWG\Parameter(name="viewed", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="office_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_study_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="authorized_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="authorizeddate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="updatedate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="rejected_reason", in="formData", type="string"),
     *     @SWG\Parameter(name="rejecteddate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="canceled_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="canceled_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="hst_nights", in="formData", type="integer"),
     *     @SWG\Parameter(name="hst_positions", in="formData", type="string"),
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
     *     path="/home-sleep-tests/{id}",
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

    public function getUncompleted(HomeSleepTests $resources, Request $request)
    {
        $patientId = $request->input('patientId', 0);

        $data = $resources->getUncompleted($patientId);

        return ApiResponse::responseOk('', $data);
    }

    public function getByType($type, HomeSleepTests $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        switch ($type) {
            case 'completed':
                $data = $resources->getCompleted($docId);
                break;
            case 'requested':
                $data = $resources->getRequested($docId);
                break;
            case 'rejected':
                $data = $resources->getRejected($docId);
                break;
            default:
                $data = [];
                break;
        }

        return ApiResponse::responseOk('', $data);
    }
}
