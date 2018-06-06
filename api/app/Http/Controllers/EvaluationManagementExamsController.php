<?php

namespace DentalSleepSolutions\Http\Controllers;

class EvaluationManagementExamsController extends BaseRestController
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
     *     path="/evaluation-management-exams",
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
     *                         @SWG\Items(ref="#/definitions/EvaluationManagementExam")
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
     *     path="/evaluation-management-exams/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/EvaluationManagementExam")
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
     *     path="/evaluation-management-exams",
     *     @SWG\Parameter(
     *         name="history",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(
     *             property="chief_complaint",
     *             type="object",
     *             @SWG\Property(property="value", type="string"),
     *             @SWG\Property(property="default", type="string")
     *         ),
     *         @SWG\Property(
     *             property="present",
     *             type="object",
     *             @SWG\Property(property="location", type="string"),
     *             @SWG\Property(property="quality", type="string"),
     *             @SWG\Property(property="severity", type="string"),
     *             @SWG\Property(property="duration", type="string"),
     *             @SWG\Property(property="timing", type="string"),
     *             @SWG\Property(property="context", type="string"),
     *             @SWG\Property(property="modifying_factor", type="string"),
     *             @SWG\Property(property="symptoms", type="string")
     *         ),
     *         @SWG\Property(
     *             property="past",
     *             type="object",
     *             @SWG\Property(
     *                 property="family",
     *                 type="object",
     *                 @SWG\Property(property="value", type="string"),
     *                 @SWG\Property(property="default", type="string")
     *             ),
     *             @SWG\Property(
     *                 property="medical",
     *                 type="object",
     *                 @SWG\Property(
     *                     property="allergens",
     *                     type="object",
     *                     @SWG\Property(property="value", type="string"),
     *                     @SWG\Property(property="default", type="string")
     *                 ),
     *                 @SWG\Property(
     *                     property="medication",
     *                     type="object",
     *                     @SWG\Property(property="value", type="string"),
     *                     @SWG\Property(property="default", type="string")
     *                 ),
     *                 @SWG\Property(
     *                     property="general",
     *                     type="object",
     *                     @SWG\Property(property="value", type="string"),
     *                     @SWG\Property(property="default", type="string")
     *                 ),
     *                 @SWG\Property(
     *                     property="dental",
     *                     type="object",
     *                     @SWG\Property(property="value", type="string"),
     *                     @SWG\Property(property="default", type="string")
     *                 )
     *             ),
     *             @SWG\Property(
     *                 property="social",
     *                 type="object",
     *                 @SWG\Property(property="value", type="string"),
     *                 @SWG\Property(property="default", type="string")
     *             )
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="systems",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(property="constitutional", type="string"),
     *         @SWG\Property(property="eyes", type="string"),
     *         @SWG\Property(property="ears_nose_mouth_throat", type="string"),
     *         @SWG\Property(property="cardiovascular", type="string"),
     *         @SWG\Property(property="respiratory", type="string"),
     *         @SWG\Property(property="gastrointestinal", type="string"),
     *         @SWG\Property(property="genitourinary", type="string"),
     *         @SWG\Property(property="musculoskeletal", type="string"),
     *         @SWG\Property(property="integumentary", type="string"),
     *         @SWG\Property(property="neurologic", type="string"),
     *         @SWG\Property(property="psychiatric", type="string"),
     *         @SWG\Property(property="endocrine", type="string"),
     *         @SWG\Property(property="hematologic_lymphatic", type="string"),
     *         @SWG\Property(property="allergic_immunologic", type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="vital_signs",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(
     *             property="height",
     *             type="object",
     *             @SWG\Property(property="feet", type="integer"),
     *             @SWG\Property(property="inches", type="integer")
     *         ),
     *         @SWG\Property(property="weight", type="float"),
     *         @SWG\Property(property="bmi", type="float"),
     *         @SWG\Property(property="blood_pressure", type="integer"),
     *         @SWG\Property(property="pulse", type="integer"),
     *         @SWG\Property(property="neck_measurement", type="integer"),
     *         @SWG\Property(property="respirations", type="integer"),
     *         @SWG\Property(property="appearance", type="string"),
     *         @SWG\Property(property="orientation", type="string"),
     *         @SWG\Property(property="mood_affect", type="string"),
     *         @SWG\Property(property="gait_station", type="string"),
     *         @SWG\Property(property="coordination_balance", type="string"),
     *         @SWG\Property(property="sensation", type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="body_area",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(property="first_description", type="string"),
     *         @SWG\Property(property="palpation", type="string"),
     *         @SWG\Property(property="rom", type="string"),
     *         @SWG\Property(property="stability", type="string"),
     *         @SWG\Property(property="strength", type="string"),
     *         @SWG\Property(property="skin", type="string"),
     *         @SWG\Property(property="second_description", type="string"),
     *         @SWG\Property(property="lips_teeth_gums", type="string"),
     *         @SWG\Property(property="oropharynx", type="string"),
     *         @SWG\Property(property="nasal_septum_turbinates", type="string")
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/EvaluationManagementExam")
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
     *     path="/evaluation-management-exams/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(
     *         name="history",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(
     *             property="chief_complaint",
     *             type="object",
     *             @SWG\Property(property="value", type="string"),
     *             @SWG\Property(property="default", type="string")
     *         ),
     *         @SWG\Property(
     *             property="present",
     *             type="object",
     *             @SWG\Property(property="location", type="string"),
     *             @SWG\Property(property="quality", type="string"),
     *             @SWG\Property(property="severity", type="string"),
     *             @SWG\Property(property="duration", type="string"),
     *             @SWG\Property(property="timing", type="string"),
     *             @SWG\Property(property="context", type="string"),
     *             @SWG\Property(property="modifying_factor", type="string"),
     *             @SWG\Property(property="symptoms", type="string")
     *         ),
     *         @SWG\Property(
     *             property="past",
     *             type="object",
     *             @SWG\Property(
     *                 property="family",
     *                 type="object",
     *                 @SWG\Property(property="value", type="string"),
     *                 @SWG\Property(property="default", type="string")
     *             ),
     *             @SWG\Property(
     *                 property="medical",
     *                 type="object",
     *                 @SWG\Property(
     *                     property="allergens",
     *                     type="object",
     *                     @SWG\Property(property="value", type="string"),
     *                     @SWG\Property(property="default", type="string")
     *                 ),
     *                 @SWG\Property(
     *                     property="medication",
     *                     type="object",
     *                     @SWG\Property(property="value", type="string"),
     *                     @SWG\Property(property="default", type="string")
     *                 ),
     *                 @SWG\Property(
     *                     property="general",
     *                     type="object",
     *                     @SWG\Property(property="value", type="string"),
     *                     @SWG\Property(property="default", type="string")
     *                 ),
     *                 @SWG\Property(
     *                     property="dental",
     *                     type="object",
     *                     @SWG\Property(property="value", type="string"),
     *                     @SWG\Property(property="default", type="string")
     *                 )
     *             ),
     *             @SWG\Property(
     *                 property="social",
     *                 type="object",
     *                 @SWG\Property(property="value", type="string"),
     *                 @SWG\Property(property="default", type="string")
     *             )
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="systems",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(property="constitutional", type="string"),
     *         @SWG\Property(property="eyes", type="string"),
     *         @SWG\Property(property="ears_nose_mouth_throat", type="string"),
     *         @SWG\Property(property="cardiovascular", type="string"),
     *         @SWG\Property(property="respiratory", type="string"),
     *         @SWG\Property(property="gastrointestinal", type="string"),
     *         @SWG\Property(property="genitourinary", type="string"),
     *         @SWG\Property(property="musculoskeletal", type="string"),
     *         @SWG\Property(property="integumentary", type="string"),
     *         @SWG\Property(property="neurologic", type="string"),
     *         @SWG\Property(property="psychiatric", type="string"),
     *         @SWG\Property(property="endocrine", type="string"),
     *         @SWG\Property(property="hematologic_lymphatic", type="string"),
     *         @SWG\Property(property="allergic_immunologic", type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="vital_signs",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(
     *             property="height",
     *             type="object",
     *             @SWG\Property(property="feet", type="integer"),
     *             @SWG\Property(property="inches", type="integer")
     *         ),
     *         @SWG\Property(property="weight", type="float"),
     *         @SWG\Property(property="bmi", type="float"),
     *         @SWG\Property(property="blood_pressure", type="integer"),
     *         @SWG\Property(property="pulse", type="integer"),
     *         @SWG\Property(property="neck_measurement", type="integer"),
     *         @SWG\Property(property="respirations", type="integer"),
     *         @SWG\Property(property="appearance", type="string"),
     *         @SWG\Property(property="orientation", type="string"),
     *         @SWG\Property(property="mood_affect", type="string"),
     *         @SWG\Property(property="gait_station", type="string"),
     *         @SWG\Property(property="coordination_balance", type="string"),
     *         @SWG\Property(property="sensation", type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="body_area",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(property="first_description", type="string"),
     *         @SWG\Property(property="palpation", type="string"),
     *         @SWG\Property(property="rom", type="string"),
     *         @SWG\Property(property="stability", type="string"),
     *         @SWG\Property(property="strength", type="string"),
     *         @SWG\Property(property="skin", type="string"),
     *         @SWG\Property(property="second_description", type="string"),
     *         @SWG\Property(property="lips_teeth_gums", type="string"),
     *         @SWG\Property(property="oropharynx", type="string"),
     *         @SWG\Property(property="nasal_septum_turbinates", type="string")
     *     ),
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
     *     path="/evaluation-management-exams/{id}",
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
