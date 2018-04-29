<?php

namespace DentalSleepSolutions\Http\Controllers;

/**
 * @todo: restore API tests if needed or delete the controller
 */
class PreviousTreatmentsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/previous-treatments",
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
     *                         @SWG\Items(ref="#/definitions/PreviousTreatment")
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
     *     path="/previous-treatments/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/PreviousTreatment")
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
     *     path="/previous-treatments",
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="polysomnographic", in="formData", type="integer"),
     *     @SWG\Parameter(name="sleep_center_name", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_study_on", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="confirmed_diagnosis", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="rdi", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="ahi", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="cpap", in="formData", type="string", required=true, pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="intolerance", in="formData", type="string", pattern="^~([0-9]+~)+$"),
     *     @SWG\Parameter(name="other_intolerance", in="formData", type="string"),
     *     @SWG\Parameter(name="other_therapy", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="other", in="formData", type="string"),
     *     @SWG\Parameter(name="affidavit", in="formData", type="string"),
     *     @SWG\Parameter(name="type_study", in="formData", type="string"),
     *     @SWG\Parameter(name="nights_wear_cpap", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="percent_night_cpap", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="custom_diagnosis", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_study_by", in="formData", type="string"),
     *     @SWG\Parameter(name="triedquittried", in="formData", type="string"),
     *     @SWG\Parameter(name="timesovertime", in="formData", type="string"),
     *     @SWG\Parameter(name="cur_cpap", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="sleep_center_name_text", in="formData", type="string"),
     *     @SWG\Parameter(name="dd_wearing", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="dd_prev", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="dd_otc", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="dd_fab", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="dd_who", in="formData", type="string"),
     *     @SWG\Parameter(name="dd_experience", in="formData", type="string"),
     *     @SWG\Parameter(name="surgery", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="parent_patientid", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/PreviousTreatment")
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
     *     path="/previous-treatments/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="polysomnographic", in="formData", type="integer"),
     *     @SWG\Parameter(name="sleep_center_name", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_study_on", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="confirmed_diagnosis", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="rdi", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="ahi", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="cpap", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="intolerance", in="formData", type="string", pattern="^~([0-9]+~)+$"),
     *     @SWG\Parameter(name="other_intolerance", in="formData", type="string"),
     *     @SWG\Parameter(name="other_therapy", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="other", in="formData", type="string"),
     *     @SWG\Parameter(name="affidavit", in="formData", type="string"),
     *     @SWG\Parameter(name="type_study", in="formData", type="string"),
     *     @SWG\Parameter(name="nights_wear_cpap", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="percent_night_cpap", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="custom_diagnosis", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_study_by", in="formData", type="string"),
     *     @SWG\Parameter(name="triedquittried", in="formData", type="string"),
     *     @SWG\Parameter(name="timesovertime", in="formData", type="string"),
     *     @SWG\Parameter(name="cur_cpap", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="sleep_center_name_text", in="formData", type="string"),
     *     @SWG\Parameter(name="dd_wearing", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="dd_prev", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="dd_otc", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="dd_fab", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="dd_who", in="formData", type="string"),
     *     @SWG\Parameter(name="dd_experience", in="formData", type="string"),
     *     @SWG\Parameter(name="surgery", in="formData", type="string", pattern="^(:?Yes|No)$"),
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
     *     path="/previous-treatments/{id}",
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
