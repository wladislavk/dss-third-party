<?php

namespace DentalSleepSolutions\Http\Controllers;

class PainTmdExamsController extends BaseRestController
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
    protected $filterByPatientKey = 'patient_id';

    /**
     * @SWG\Get(
     *     path="/pain-tmd-exams",
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
     *                         @SWG\Items(ref="#/definitions/PainTmdExam")
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
     *     path="/pain-tmd-exams/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/PainTmdExam")
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
     *     path="/pain-tmd-exams",
     *     @SWG\Parameter(
     *         name="description",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(property="chief_complaint", type="string"),
     *         @SWG\Property(property="extra_info", type="string"),
     *         @SWG\Property(
     *             property="pain",
     *             type="object",
     *             @SWG\Property(property="ease", type="string"),
     *             @SWG\Property(property="worse", type="string")
     *         ),
     *         @SWG\Property(property="treatment_goals", type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="pain",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(
     *             property="back",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="upper",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="middle",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="lower",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="jaw",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="joint",
     *                 type="object",
     *                 @SWG\Property(
     *                     property="general",
     *                     type="object",
     *                     @SWG\Property(property="level", type="integer")
     *                 ),
     *                 @SWG\Property(
     *                     property="opening",
     *                     type="object",
     *                     @SWG\Property(property="position", type="string"),
     *                     @SWG\Property(property="level", type="integer")
     *                 ),
     *                 @SWG\Property(
     *                     property="chewing",
     *                     type="object",
     *                     @SWG\Property(property="position", type="string"),
     *                     @SWG\Property(property="level", type="integer")
     *                 ),
     *                 @SWG\Property(
     *                     property="at_rest",
     *                     type="object",
     *                     @SWG\Property(property="position", type="string"),
     *                     @SWG\Property(property="level", type="integer")
     *                 )
     *             )
     *         ),
     *         @SWG\Property(
     *             property="eyes",
     *             type="object",
     *             @SWG\Property(
     *                 property="behind",
     *                 type="object",
     *                 @SWG\Property(property="checked", type="boolean"),
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="watery",
     *                 type="object",
     *                 @SWG\Property(property="checked", type="boolean"),
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="visual_disturbance",
     *                 type="object",
     *                 @SWG\Property(property="checked", type="boolean"),
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="ears",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="behind",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="front",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="ringing",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="throat",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="swallowing",
     *                 type="object",
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         )
     *         @SWG\Property(
     *             property="face",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="neck",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="shoulder",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="teeth",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="symptom_review",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(property="onset_of_event", type="string"),
     *         @SWG\Property(property="provocation", type="string"),
     *         @SWG\Property(property="quality_of_pain", type="string"),
     *         @SWG\Property(property="region_and_radiation", type="string"),
     *         @SWG\Property(property="severity", type="string"),
     *         @SWG\Property(property="time", type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="symptoms",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(
     *             property="jaw",
     *             type="object",
     *             @SWG\Property(
     *                 property="locks",
     *                 type="object",
     *                 @SWG\Property(property="open", type="boolean"),
     *                 @SWG\Property(property="closed", type="boolean")
     *             ),
     *             @SWG\Property(
     *                 property="opening",
     *                 type="object",
     *                 @SWG\Property(property="clicks_pops", type="boolean"),
     *                 @SWG\Property(property="position", type="string")
     *             ),
     *             @SWG\Property(
     *                 property="closing",
     *                 type="object",
     *                 @SWG\Property(property="clicks_pops", type="boolean"),
     *                 @SWG\Property(property="position", type="string")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="clenching",
     *             type="object",
     *             @SWG\Property(property="daytime", type="boolean"),
     *             @SWG\Property(property="nighttime", type="boolean")
     *         ),
     *         @SWG\Property(
     *             property="mouth",
     *             type="object",
     *             @SWG\Property(property="limited_opening", type="boolean")
     *         ),
     *         @SWG\Property(
     *             property="grinding",
     *             type="object",
     *             @SWG\Property(property="daytime", type="boolean"),
     *             @SWG\Property(property="nighttime", type="boolean")
     *         ),
     *         @SWG\Property(property="muscle_twitching", type="boolean"),
     *         @SWG\Property(
     *             property="numbness",
     *             type="object",
     *             @SWG\Property(property="lip", type="boolean"),
     *             @SWG\Property(property="jawbone", type="boolean")
     *         ),
     *         @SWG\Property(
     *             property="other",
     *             type="object",
     *             @SWG\Property(property="dry_mouth", type="boolean"),
     *             @SWG\Property(property="cheek_biting", type="boolean"),
     *             @SWG\Property(property="burning_tongue", type="boolean"),
     *             @SWG\Property(property="dizziness", type="boolean"),
     *             @SWG\Property(property="buzzing", type="boolean"),
     *             @SWG\Property(property="swallowing", type="boolean"),
     *             @SWG\Property(property="neck_stiffness", type="boolean"),
     *             @SWG\Property(property="vision_changes", type="boolean"),
     *             @SWG\Property(property="sciatica", type="boolean"),
     *             @SWG\Property(property="ear_infections", type="boolean"),
     *             @SWG\Property(property="foreign_feeling", type="boolean"),
     *             @SWG\Property(property="shoulder_stiffness", type="boolean"),
     *             @SWG\Property(property="blurred_vision", type="string"),
     *             @SWG\Property(property="fingers_tingling", type="boolean"),
     *             @SWG\Property(property="ear_congestion", type="boolean"),
     *             @SWG\Property(property="neck_swelling", type="boolean"),
     *             @SWG\Property(property="scoliosis", type="boolean"),
     *             @SWG\Property(property="visual_disturbances", type="boolean"),
     *             @SWG\Property(property="finger_hand_numbness", type="boolean"),
     *             @SWG\Property(property="hearing_loss", type="boolean"),
     *             @SWG\Property(property="gland_swelling", type="boolean"),
     *             @SWG\Property(property="chronic_sinusitis", type="boolean"),
     *             @SWG\Property(property="thyroid_swelling", type="boolean"),
     *             @SWG\Property(property="difficult_breathing", type="boolean"),
     *             @SWG\Property(property="description", type="string")
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="headaches",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(property="checked", type="boolean"),
     *         @SWG\Property(
     *             property="front",
     *             type="object",
     *             @SWG\Property(property="frequency", type="string"),
     *             @SWG\Property(property="duration", type="string"),
     *             @SWG\Property(property="level", type="integer")
     *         ),
     *         @SWG\Property(
     *             property="top",
     *             type="object",
     *             @SWG\Property(property="frequency", type="string"),
     *             @SWG\Property(property="duration", type="string"),
     *             @SWG\Property(property="level", type="integer")
     *         ),
     *         @SWG\Property(
     *             property="back",
     *             type="object",
     *             @SWG\Property(property="frequency", type="string"),
     *             @SWG\Property(property="duration", type="string"),
     *             @SWG\Property(property="level", type="integer")
     *         ),
     *         @SWG\Property(
     *             property="temple",
     *             type="object",
     *             @SWG\Property(property="position", type="string"),
     *             @SWG\Property(property="frequency", type="string"),
     *             @SWG\Property(property="duration", type="string"),
     *             @SWG\Property(property="level", type="integer")
     *         ),
     *         @SWG\Property(
     *             property="eyes",
     *             type="object",
     *             @SWG\Property(property="position", type="string"),
     *             @SWG\Property(property="frequency", type="string"),
     *             @SWG\Property(property="duration", type="string"),
     *             @SWG\Property(property="level", type="integer")
     *         ),
     *         @SWG\Property(
     *             property="symptoms",
     *             type="object",
     *             @SWG\Property(property="dizziness", type="boolean"),
     *             @SWG\Property(property="noise_sensitivity", type="boolean"),
     *             @SWG\Property(property="throbbling", type="boolean"),
     *             @SWG\Property(property="double_vision", type="boolean"),
     *             @SWG\Property(property="light_sensitivity", type="boolean"),
     *             @SWG\Property(property="vomiting", type="boolean"),
     *             @SWG\Property(property="fatigue", type="boolean"),
     *             @SWG\Property(property="nausea", type="boolean"),
     *             @SWG\Property(property="eye_nose_running", type="boolean"),
     *             @SWG\Property(property="sinus_congestion", type="boolean"),
     *             @SWG\Property(property="burning", type="boolean"),
     *             @SWG\Property(
     *                 property="other",
     *                 type="object",
     *                 @SWG\Property(property="checked", type="boolean"),
     *                 @SWG\Property(property="details", type="string")
     *             ),
     *             @SWG\Property(property="dull_aching", type="boolean")
     *         ),
     *         @SWG\Property(
     *             property="migraines",
     *             type="object",
     *             @SWG\Property(property="checked", type="boolean"),
     *             @SWG\Property(property="specialist", type="string"),
     *             @SWG\Property(property="occurrence", type="string")
     *         )
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/PainTmdExam")
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
     *     path="/pain-tmd-exams/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(
     *         name="description",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(property="chief_complaint", type="string"),
     *         @SWG\Property(property="extra_info", type="string"),
     *         @SWG\Property(
     *             property="pain",
     *             type="object",
     *             @SWG\Property(property="ease", type="string"),
     *             @SWG\Property(property="worse", type="string")
     *         ),
     *         @SWG\Property(property="treatment_goals", type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="pain",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(
     *             property="back",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="upper",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="middle",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="lower",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="jaw",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="joint",
     *                 type="object",
     *                 @SWG\Property(
     *                     property="general",
     *                     type="object",
     *                     @SWG\Property(property="level", type="integer")
     *                 ),
     *                 @SWG\Property(
     *                     property="opening",
     *                     type="object",
     *                     @SWG\Property(property="position", type="string"),
     *                     @SWG\Property(property="level", type="integer")
     *                 ),
     *                 @SWG\Property(
     *                     property="chewing",
     *                     type="object",
     *                     @SWG\Property(property="position", type="string"),
     *                     @SWG\Property(property="level", type="integer")
     *                 ),
     *                 @SWG\Property(
     *                     property="at_rest",
     *                     type="object",
     *                     @SWG\Property(property="position", type="string"),
     *                     @SWG\Property(property="level", type="integer")
     *                 )
     *             )
     *         ),
     *         @SWG\Property(
     *             property="eyes",
     *             type="object",
     *             @SWG\Property(
     *                 property="behind",
     *                 type="object",
     *                 @SWG\Property(property="checked", type="boolean"),
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="watery",
     *                 type="object",
     *                 @SWG\Property(property="checked", type="boolean"),
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="visual_disturbance",
     *                 type="object",
     *                 @SWG\Property(property="checked", type="boolean"),
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="ears",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="behind",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="front",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="ringing",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="throat",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="level", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="swallowing",
     *                 type="object",
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         )
     *         @SWG\Property(
     *             property="face",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="neck",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="shoulder",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="teeth",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string"),
     *                 @SWG\Property(property="level", type="integer")
     *             )
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="symptom_review",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(property="onset_of_event", type="string"),
     *         @SWG\Property(property="provocation", type="string"),
     *         @SWG\Property(property="quality_of_pain", type="string"),
     *         @SWG\Property(property="region_and_radiation", type="string"),
     *         @SWG\Property(property="severity", type="string"),
     *         @SWG\Property(property="time", type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="symptoms",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(
     *             property="jaw",
     *             type="object",
     *             @SWG\Property(
     *                 property="locks",
     *                 type="object",
     *                 @SWG\Property(property="open", type="boolean"),
     *                 @SWG\Property(property="closed", type="boolean")
     *             ),
     *             @SWG\Property(
     *                 property="opening",
     *                 type="object",
     *                 @SWG\Property(property="clicks_pops", type="boolean"),
     *                 @SWG\Property(property="position", type="string")
     *             ),
     *             @SWG\Property(
     *                 property="closing",
     *                 type="object",
     *                 @SWG\Property(property="clicks_pops", type="boolean"),
     *                 @SWG\Property(property="position", type="string")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="clenching",
     *             type="object",
     *             @SWG\Property(property="daytime", type="boolean"),
     *             @SWG\Property(property="nighttime", type="boolean")
     *         ),
     *         @SWG\Property(
     *             property="mouth",
     *             type="object",
     *             @SWG\Property(property="limited_opening", type="boolean")
     *         ),
     *         @SWG\Property(
     *             property="grinding",
     *             type="object",
     *             @SWG\Property(property="daytime", type="boolean"),
     *             @SWG\Property(property="nighttime", type="boolean")
     *         ),
     *         @SWG\Property(property="muscle_twitching", type="boolean"),
     *         @SWG\Property(
     *             property="numbness",
     *             type="object",
     *             @SWG\Property(property="lip", type="boolean"),
     *             @SWG\Property(property="jawbone", type="boolean")
     *         ),
     *         @SWG\Property(
     *             property="other",
     *             type="object",
     *             @SWG\Property(property="dry_mouth", type="boolean"),
     *             @SWG\Property(property="cheek_biting", type="boolean"),
     *             @SWG\Property(property="burning_tongue", type="boolean"),
     *             @SWG\Property(property="dizziness", type="boolean"),
     *             @SWG\Property(property="buzzing", type="boolean"),
     *             @SWG\Property(property="swallowing", type="boolean"),
     *             @SWG\Property(property="neck_stiffness", type="boolean"),
     *             @SWG\Property(property="vision_changes", type="boolean"),
     *             @SWG\Property(property="sciatica", type="boolean"),
     *             @SWG\Property(property="ear_infections", type="boolean"),
     *             @SWG\Property(property="foreign_feeling", type="boolean"),
     *             @SWG\Property(property="shoulder_stiffness", type="boolean"),
     *             @SWG\Property(property="blurred_vision", type="string"),
     *             @SWG\Property(property="fingers_tingling", type="boolean"),
     *             @SWG\Property(property="ear_congestion", type="boolean"),
     *             @SWG\Property(property="neck_swelling", type="boolean"),
     *             @SWG\Property(property="scoliosis", type="boolean"),
     *             @SWG\Property(property="visual_disturbances", type="boolean"),
     *             @SWG\Property(property="finger_hand_numbness", type="boolean"),
     *             @SWG\Property(property="hearing_loss", type="boolean"),
     *             @SWG\Property(property="gland_swelling", type="boolean"),
     *             @SWG\Property(property="chronic_sinusitis", type="boolean"),
     *             @SWG\Property(property="thyroid_swelling", type="boolean"),
     *             @SWG\Property(property="difficult_breathing", type="boolean"),
     *             @SWG\Property(property="description", type="string")
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="headaches",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(property="checked", type="boolean"),
     *         @SWG\Property(
     *             property="front",
     *             type="object",
     *             @SWG\Property(property="frequency", type="string"),
     *             @SWG\Property(property="duration", type="string"),
     *             @SWG\Property(property="level", type="integer")
     *         ),
     *         @SWG\Property(
     *             property="top",
     *             type="object",
     *             @SWG\Property(property="frequency", type="string"),
     *             @SWG\Property(property="duration", type="string"),
     *             @SWG\Property(property="level", type="integer")
     *         ),
     *         @SWG\Property(
     *             property="back",
     *             type="object",
     *             @SWG\Property(property="frequency", type="string"),
     *             @SWG\Property(property="duration", type="string"),
     *             @SWG\Property(property="level", type="integer")
     *         ),
     *         @SWG\Property(
     *             property="temple",
     *             type="object",
     *             @SWG\Property(property="position", type="string"),
     *             @SWG\Property(property="frequency", type="string"),
     *             @SWG\Property(property="duration", type="string"),
     *             @SWG\Property(property="level", type="integer")
     *         ),
     *         @SWG\Property(
     *             property="eyes",
     *             type="object",
     *             @SWG\Property(property="position", type="string"),
     *             @SWG\Property(property="frequency", type="string"),
     *             @SWG\Property(property="duration", type="string"),
     *             @SWG\Property(property="level", type="integer")
     *         ),
     *         @SWG\Property(
     *             property="symptoms",
     *             type="object",
     *             @SWG\Property(property="dizziness", type="boolean"),
     *             @SWG\Property(property="noise_sensitivity", type="boolean"),
     *             @SWG\Property(property="throbbling", type="boolean"),
     *             @SWG\Property(property="double_vision", type="boolean"),
     *             @SWG\Property(property="light_sensitivity", type="boolean"),
     *             @SWG\Property(property="vomiting", type="boolean"),
     *             @SWG\Property(property="fatigue", type="boolean"),
     *             @SWG\Property(property="nausea", type="boolean"),
     *             @SWG\Property(property="eye_nose_running", type="boolean"),
     *             @SWG\Property(property="sinus_congestion", type="boolean"),
     *             @SWG\Property(property="burning", type="boolean"),
     *             @SWG\Property(
     *                 property="other",
     *                 type="object",
     *                 @SWG\Property(property="checked", type="boolean"),
     *                 @SWG\Property(property="details", type="string")
     *             ),
     *             @SWG\Property(property="dull_aching", type="boolean")
     *         ),
     *         @SWG\Property(
     *             property="migraines",
     *             type="object",
     *             @SWG\Property(property="checked", type="boolean"),
     *             @SWG\Property(property="specialist", type="string"),
     *             @SWG\Property(property="occurrence", type="string")
     *         )
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
     *     path="/pain-tmd-exams/{id}",
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
