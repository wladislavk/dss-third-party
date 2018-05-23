<?php

namespace DentalSleepSolutions\Http\Controllers;

class AdvancedPainTmdExamsController extends BaseRestController
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
     *     path="/advanced-pain-tmd-exams",
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
     *                         @SWG\Items(ref="#/definitions/AdvancedPainTmdExam")
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
     *     path="/advanced-pain-tmd-exams/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/AdvancedPainTmdExam")
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
     *     path="/advanced-pain-tmd-exams",
     *     @SWG\Parameter(
     *         name="cervical",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(
     *             property="extension",
     *             type="object",
     *             @SWG\Property(property="rom", type="string"),
     *             @SWG\Property(property="pain", type="integer")
     *         ),
     *         @SWG\Property(
     *             property="flexion",
     *             type="object",
     *             @SWG\Property(property="rom", type="string"),
     *             @SWG\Property(property="pain", type="integer")
     *         ),
     *         @SWG\Property(
     *             property="rotation",
     *             type="object",
     *             @SWG\Property(
     *                 property="right",
     *                 type="object",
     *                 @SWG\Property(property="rom", type="string"),
     *                 @SWG\Property(property="pain", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="left",
     *                 type="object",
     *                 @SWG\Property(property="rom", type="string"),
     *                 @SWG\Property(property="pain", type="integer")
     *             ),
     *             @SWG\Property(property="symmetry", type="string")
     *         ),
     *         @SWG\Property(
     *             property="side_bend",
     *             type="object",
     *             @SWG\Property(
     *                 property="right",
     *                 type="object",
     *                 @SWG\Property(property="rom", type="string"),
     *                 @SWG\Property(property="pain", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="left",
     *                 type="object",
     *                 @SWG\Property(property="rom", type="string"),
     *                 @SWG\Property(property="pain", type="integer")
     *             ),
     *             @SWG\Property(property="symmetry", type="string")
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="morphology",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(
     *             property="midline",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string")
     *             ),
     *             @SWG\Property(
     *                 property="facial",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string")
     *             ),
     *             @SWG\Property(
     *                 property="teeth",
     *                 type="object",
     *                 @SWG\Property(
     *                     property="maxila",
     *                     type="object",
     *                     @SWG\Property(property="position", type="string")
     *                 ),
     *                 @SWG\Property(
     *                     property="mandible",
     *                     type="object",
     *                     @SWG\Property(property="position", type="string")
     *                 )
     *             ),
     *             @SWG\Property(
     *                 property="eyes",
     *                 type="object",
     *                 @SWG\Property(
     *                     property="right",
     *                     type="object",
     *                     @SWG\Property(property="position", type="string")
     *                 ),
     *                 @SWG\Property(
     *                     property="left",
     *                     type="object",
     *                     @SWG\Property(property="position", type="string")
     *                 )
     *             )
     *         ),
     *         @SWG\Property(
     *             property="posture",
     *             type="object",
     *             @SWG\Property(
     *                 property="head",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string")
     *             ),
     *             @SWG\Property(
     *                 property="standing",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string")
     *             ),
     *             @SWG\Property(
     *                 property="sitting",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="shoulders",
     *             type="object",
     *             @SWG\Property(property="position", type="string")
     *         ),
     *         @SWG\Property(
     *             property="hips",
     *             type="object",
     *             @SWG\Property(property="position", type="string")
     *         ),
     *         @SWG\Property(
     *             property="spine",
     *             type="object",
     *             @SWG\Property(property="position", type="string")
     *         ),
     *         @SWG\Property(
     *             property="pupillary_plane",
     *             type="object",
     *             @SWG\Property(property="position", type="string")
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="cranial_nerve",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(property="olfactory", type="boolean"),
     *         @SWG\Property(property="optic", type="boolean"),
     *         @SWG\Property(property="occulomotor", type="boolean"),
     *         @SWG\Property(property="trochlear", type="boolean"),
     *         @SWG\Property(property="trigeminal", type="boolean"),
     *         @SWG\Property(property="abducens", type="boolean"),
     *         @SWG\Property(property="facial", type="boolean"),
     *         @SWG\Property(property="acoustic", type="boolean"),
     *         @SWG\Property(property="glossopharyngeal", type="boolean"),
     *         @SWG\Property(property="vagus", type="boolean"),
     *         @SWG\Property(property="accessory", type="boolean"),
     *         @SWG\Property(property="hypoglossal", type="boolean")
     *     ),
     *     @SWG\Parameter(
     *         name="occlusal",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(
     *             property="contacts",
     *             type="object",
     *             @SWG\Property(
     *                 property="working",
     *                 type="object",
     *                 @SWG\Property(property="right", type="array"),
     *                 @SWG\Property(property="left", type="array")
     *             ),
     *             @SWG\Property(
     *                 property="non_working",
     *                 type="object",
     *                 @SWG\Property(property="right", type="array"),
     *                 @SWG\Property(property="left", type="array")
     *             )
     *         ),
     *         @SWG\Property(property="crossover_interferences", type="array")
     *     ),
     *     @SWG\Parameter(
     *         name="other",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(property="guidance", type="string"),
     *         @SWG\Property(property="notes", type="string")
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/AdvancedPainTmdExam")
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
     *     path="/advanced-pain-tmd-exams/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(
     *         name="cervical",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(
     *             property="extension",
     *             type="object",
     *             @SWG\Property(property="rom", type="string"),
     *             @SWG\Property(property="pain", type="integer")
     *         ),
     *         @SWG\Property(
     *             property="flexion",
     *             type="object",
     *             @SWG\Property(property="rom", type="string"),
     *             @SWG\Property(property="pain", type="integer")
     *         ),
     *         @SWG\Property(
     *             property="rotation",
     *             type="object",
     *             @SWG\Property(
     *                 property="right",
     *                 type="object",
     *                 @SWG\Property(property="rom", type="string"),
     *                 @SWG\Property(property="pain", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="left",
     *                 type="object",
     *                 @SWG\Property(property="rom", type="string"),
     *                 @SWG\Property(property="pain", type="integer")
     *             ),
     *             @SWG\Property(property="symmetry", type="string")
     *         ),
     *         @SWG\Property(
     *             property="side_bend",
     *             type="object",
     *             @SWG\Property(
     *                 property="right",
     *                 type="object",
     *                 @SWG\Property(property="rom", type="string"),
     *                 @SWG\Property(property="pain", type="integer")
     *             ),
     *             @SWG\Property(
     *                 property="left",
     *                 type="object",
     *                 @SWG\Property(property="rom", type="string"),
     *                 @SWG\Property(property="pain", type="integer")
     *             ),
     *             @SWG\Property(property="symmetry", type="string")
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="morphology",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(
     *             property="midline",
     *             type="object",
     *             @SWG\Property(
     *                 property="general",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string")
     *             ),
     *             @SWG\Property(
     *                 property="facial",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string")
     *             ),
     *             @SWG\Property(
     *                 property="teeth",
     *                 type="object",
     *                 @SWG\Property(
     *                     property="maxila",
     *                     type="object",
     *                     @SWG\Property(property="position", type="string")
     *                 ),
     *                 @SWG\Property(
     *                     property="mandible",
     *                     type="object",
     *                     @SWG\Property(property="position", type="string")
     *                 )
     *             ),
     *             @SWG\Property(
     *                 property="eyes",
     *                 type="object",
     *                 @SWG\Property(
     *                     property="right",
     *                     type="object",
     *                     @SWG\Property(property="position", type="string")
     *                 ),
     *                 @SWG\Property(
     *                     property="left",
     *                     type="object",
     *                     @SWG\Property(property="position", type="string")
     *                 )
     *             )
     *         ),
     *         @SWG\Property(
     *             property="posture",
     *             type="object",
     *             @SWG\Property(
     *                 property="head",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string")
     *             ),
     *             @SWG\Property(
     *                 property="standing",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string")
     *             ),
     *             @SWG\Property(
     *                 property="sitting",
     *                 type="object",
     *                 @SWG\Property(property="position", type="string")
     *             )
     *         ),
     *         @SWG\Property(
     *             property="shoulders",
     *             type="object",
     *             @SWG\Property(property="position", type="string")
     *         ),
     *         @SWG\Property(
     *             property="hips",
     *             type="object",
     *             @SWG\Property(property="position", type="string")
     *         ),
     *         @SWG\Property(
     *             property="spine",
     *             type="object",
     *             @SWG\Property(property="position", type="string")
     *         ),
     *         @SWG\Property(
     *             property="pupillary_plane",
     *             type="object",
     *             @SWG\Property(property="position", type="string")
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="cranial_nerve",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(property="olfactory", type="boolean"),
     *         @SWG\Property(property="optic", type="boolean"),
     *         @SWG\Property(property="occulomotor", type="boolean"),
     *         @SWG\Property(property="trochlear", type="boolean"),
     *         @SWG\Property(property="trigeminal", type="boolean"),
     *         @SWG\Property(property="abducens", type="boolean"),
     *         @SWG\Property(property="facial", type="boolean"),
     *         @SWG\Property(property="acoustic", type="boolean"),
     *         @SWG\Property(property="glossopharyngeal", type="boolean"),
     *         @SWG\Property(property="vagus", type="boolean"),
     *         @SWG\Property(property="accessory", type="boolean"),
     *         @SWG\Property(property="hypoglossal", type="boolean")
     *     ),
     *     @SWG\Parameter(
     *         name="occlusal",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(
     *             property="contacts",
     *             type="object",
     *             @SWG\Property(
     *                 property="working",
     *                 type="object",
     *                 @SWG\Property(property="right", type="array"),
     *                 @SWG\Property(property="left", type="array")
     *             ),
     *             @SWG\Property(
     *                 property="non_working",
     *                 type="object",
     *                 @SWG\Property(property="right", type="array"),
     *                 @SWG\Property(property="left", type="array")
     *             )
     *         ),
     *         @SWG\Property(property="crossover_interferences", type="array")
     *     ),
     *     @SWG\Parameter(
     *         name="other",
     *         in="formData",
     *         type="object",
     *         @SWG\Property(property="guidance", type="string"),
     *         @SWG\Property(property="notes", type="string")
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
     *     path="/advanced-pain-tmd-exams/{id}",
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
