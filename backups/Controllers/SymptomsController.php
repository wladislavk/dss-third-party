<?php

namespace DentalSleepSolutions\Http\Controllers;

class SymptomsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/symptoms",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/Symptom"))
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
     *     path="/symptoms/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Symptom"))
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
     *     path="/symptoms",
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="member_no", in="formData", type="string"),
     *     @SWG\Parameter(name="group_no", in="formData", type="string"),
     *     @SWG\Parameter(name="plan_no", in="formData", type="string"),
     *     @SWG\Parameter(name="primary_care_physician", in="formData", type="string"),
     *     @SWG\Parameter(name="feet", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="inches", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="weight", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="bmi", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="sleep_qual", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="complaintid", in="formData", type="string", pattern="^(:?[0-9]+\|[0-9]+~)+$"),
     *     @SWG\Parameter(name="other_complaint", in="formData", type="string"),
     *     @SWG\Parameter(name="additional_paragraph", in="formData", type="string"),
     *     @SWG\Parameter(name="energy_level", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="snoring_sound", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="wake_night", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="breathing_night", in="formData", type="string"),
     *     @SWG\Parameter(name="morning_headaches", in="formData", type="string"),
     *     @SWG\Parameter(name="hours_sleep", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="quit_breathing", in="formData", type="string"),
     *     @SWG\Parameter(name="bed_time_partner", in="formData", type="string", pattern="^(:?Yes|Sometimes|No)$"),
     *     @SWG\Parameter(name="sleep_same_room", in="formData", type="string", pattern="^(:?Yes|Sometimes|No)$"),
     *     @SWG\Parameter(name="told_you_snore", in="formData", type="string", pattern="^(:?Yes|Sometimes|No)$"),
     *     @SWG\Parameter(name="main_reason", in="formData", type="string"),
     *     @SWG\Parameter(name="main_reason_other", in="formData", type="string"),
     *     @SWG\Parameter(name="exam_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="chief_complaint_text", in="formData", type="string"),
     *     @SWG\Parameter(name="tss", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="ess", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="parent_patientid", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Symptom"))
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
     *     path="/symptoms/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="member_no", in="formData", type="string"),
     *     @SWG\Parameter(name="group_no", in="formData", type="string"),
     *     @SWG\Parameter(name="plan_no", in="formData", type="string"),
     *     @SWG\Parameter(name="primary_care_physician", in="formData", type="string"),
     *     @SWG\Parameter(name="feet", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="inches", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="weight", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="bmi", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="sleep_qual", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="complaintid", in="formData", type="string", pattern="^(:?[0-9]+\|[0-9]+~)+$"),
     *     @SWG\Parameter(name="other_complaint", in="formData", type="string"),
     *     @SWG\Parameter(name="additional_paragraph", in="formData", type="string"),
     *     @SWG\Parameter(name="energy_level", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="snoring_sound", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="wake_night", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="breathing_night", in="formData", type="string"),
     *     @SWG\Parameter(name="morning_headaches", in="formData", type="string"),
     *     @SWG\Parameter(name="hours_sleep", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="quit_breathing", in="formData", type="string"),
     *     @SWG\Parameter(name="bed_time_partner", in="formData", type="string", pattern="^(:?Yes|Sometimes|No)$"),
     *     @SWG\Parameter(name="sleep_same_room", in="formData", type="string", pattern="^(:?Yes|Sometimes|No)$"),
     *     @SWG\Parameter(name="told_you_snore", in="formData", type="string", pattern="^(:?Yes|Sometimes|No)$"),
     *     @SWG\Parameter(name="main_reason", in="formData", type="string"),
     *     @SWG\Parameter(name="main_reason_other", in="formData", type="string"),
     *     @SWG\Parameter(name="exam_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="chief_complaint_text", in="formData", type="string"),
     *     @SWG\Parameter(name="tss", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="ess", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="parent_patientid", in="formData", type="integer"),
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
     *     path="/symptoms/{id}",
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
