<?php

namespace DentalSleepSolutions\Http\Controllers;

class TongueClinicalExamsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/tongue-clinical-exams",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/TongueClinicalExam"))
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
     *     path="/tongue-clinical-exams/{tongue_clinical_exams}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/TongueClinicalExam"))
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
     *     path="/tongue-clinical-exams",
     *     @SWG\Parameter(name="formid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="blood_pressure", in="formData", type="string", pattern="^[1-2][0-9]{2}\/([5-9][0-9]|1[0-9]{2})$"),
     *     @SWG\Parameter(name="pulse", in="formData", type="string"),
     *     @SWG\Parameter(name="neck_measurement", in="formData", type="string", pattern="^([0-9]*[.])?[0-9]+$"),
     *     @SWG\Parameter(name="bmi", in="formData", type="string", pattern="^[0-9]+\.[0-9]+$"),
     *     @SWG\Parameter(name="additional_paragraph", in="formData", type="string"),
     *     @SWG\Parameter(name="tongue", in="formData", type="string", pattern="^~([0-9]~)+$"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/TongueClinicalExam"))
     *             )
     *         }
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
     *     path="/tongue-clinical-exams/{tongue_clinical_exams}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="blood_pressure", in="formData", type="string", pattern="^[1-2][0-9]{2}\/([5-9][0-9]|1[0-9]{2})$"),
     *     @SWG\Parameter(name="pulse", in="formData", type="string"),
     *     @SWG\Parameter(name="neck_measurement", in="formData", type="string", pattern="^([0-9]*[.])?[0-9]+$"),
     *     @SWG\Parameter(name="bmi", in="formData", type="string", pattern="^[0-9]+\.[0-9]+$"),
     *     @SWG\Parameter(name="additional_paragraph", in="formData", type="string"),
     *     @SWG\Parameter(name="tongue", in="formData", type="string", pattern="^~([0-9]~)+$"),
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
     *     path="/tongue-clinical-exams/{tongue_clinical_exams}",
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
