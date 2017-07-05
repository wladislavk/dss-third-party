<?php

namespace DentalSleepSolutions\Http\Controllers;

class DentalClinicalExamsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/dental-clinical-exams",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/DentalClinicalExam"))
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
     *     path="/dental-clinical-exams/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/DentalClinicalExam"))
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
     *     path="/dental-clinical-exams",
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="exam_teeth", in="formData", type="string"),
     *     @SWG\Parameter(name="other_exam_teeth", in="formData", type="string"),
     *     @SWG\Parameter(name="caries", in="formData", type="string"),
     *     @SWG\Parameter(name="where_facets", in="formData", type="string"),
     *     @SWG\Parameter(name="cracked_fractured", in="formData", type="string"),
     *     @SWG\Parameter(name="old_worn_inadequate_restorations", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_class_right", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_division_right", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_class_left", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_division_left", in="formData", type="string"),
     *     @SWG\Parameter(name="additional_paragraph", in="formData", type="string"),
     *     @SWG\Parameter(name="initial_tooth", in="formData", type="string"),
     *     @SWG\Parameter(name="open_proximal", in="formData", type="string"),
     *     @SWG\Parameter(name="deistema", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="missing", in="formData", type="string"),
     *     @SWG\Parameter(name="crossbite", in="formData", type="string"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/DentalClinicalExam"))
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
     *     path="/dental-clinical-exams/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="exam_teeth", in="formData", type="string"),
     *     @SWG\Parameter(name="other_exam_teeth", in="formData", type="string"),
     *     @SWG\Parameter(name="caries", in="formData", type="string"),
     *     @SWG\Parameter(name="where_facets", in="formData", type="string"),
     *     @SWG\Parameter(name="cracked_fractured", in="formData", type="string"),
     *     @SWG\Parameter(name="old_worn_inadequate_restorations", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_class_right", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_division_right", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_class_left", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_division_left", in="formData", type="string"),
     *     @SWG\Parameter(name="additional_paragraph", in="formData", type="string"),
     *     @SWG\Parameter(name="initial_tooth", in="formData", type="string"),
     *     @SWG\Parameter(name="open_proximal", in="formData", type="string"),
     *     @SWG\Parameter(name="deistema", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="missing", in="formData", type="string"),
     *     @SWG\Parameter(name="crossbite", in="formData", type="string"),
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
     *     path="/dental-clinical-exams/{id}",
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
