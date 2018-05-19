<?php

namespace DentalSleepSolutions\Http\Controllers;

class AssessmentPlanExamsController extends BaseRestController
{
    /** @var string */
    protected $ipAddressKey = 'ip_address';

    /** @var string */
    protected $patientKey = 'patient_id';

    /** @var string */
    protected $doctorKey = 'doc_id';

    /** @var string */
    protected $createdByUserKey = 'created_by_user';

    /** @var string */
    protected $createdByAdminKey = 'created_by_admin';

    /** @var string */
    protected $updatedByUserKey = 'updated_by_user';

    /** @var string */
    protected $updatedByAdminKey = 'updated_by_admin';

    /** @var string */
    protected $filterByDoctorKey = 'doc_id';

    /** @var string */
    protected $filterByPatientKey = 'patient_id';

    /**
     * @SWG\Get(
     *     path="/assessment-plan-exams",
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
     *                         @SWG\Items(ref="#/definitions/AssessmentPlanExam")
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
     *     path="/assessment-plan-exams/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/AssessmentPlanExam")
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
     *     path="/assessment-plan-exams",
     *     @SWG\Parameter(name="assessment_codes", in="formData", type="array"),
     *     @SWG\Parameter(name="assessment_description", in="formData", type="string"),
     *     @SWG\Parameter(name="treatment_codes", in="formData", type="array"),
     *     @SWG\Parameter(name="treatment_description", in="formData", type="string"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/AssessmentPlanExam")
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
     *     path="/assessment-plan-exams/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="assessment_codes", in="formData", type="array"),
     *     @SWG\Parameter(name="assessment_description", in="formData", type="string"),
     *     @SWG\Parameter(name="treatment_codes", in="formData", type="array"),
     *     @SWG\Parameter(name="treatment_description", in="formData", type="string"),
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
     *     path="/assessment-plan-exams/{id}",
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
