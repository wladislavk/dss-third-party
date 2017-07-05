<?php

namespace DentalSleepSolutions\Http\Controllers;

class SocialHistoriesController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/social-histories",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/SocialHistory"))
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
     *     path="/social-histories/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/SocialHistory"))
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
     *     path="/social-histories",
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="family_had", in="formData", type="string"),
     *     @SWG\Parameter(name="family_diagnosed", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="additional_paragraph", in="formData", type="string"),
     *     @SWG\Parameter(name="alcohol", in="formData", type="string"),
     *     @SWG\Parameter(name="sedative", in="formData", type="string"),
     *     @SWG\Parameter(name="caffeine", in="formData", type="string"),
     *     @SWG\Parameter(name="smoke", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="smoke_packs", in="formData", type="string", pattern="^[0-9]{1,2}$"),
     *     @SWG\Parameter(name="tobacco", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="parent_patientid", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/SocialHistory"))
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
     *     path="/social-histories/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="family_had", in="formData", type="string"),
     *     @SWG\Parameter(name="family_diagnosed", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="additional_paragraph", in="formData", type="string"),
     *     @SWG\Parameter(name="alcohol", in="formData", type="string"),
     *     @SWG\Parameter(name="sedative", in="formData", type="string"),
     *     @SWG\Parameter(name="caffeine", in="formData", type="string"),
     *     @SWG\Parameter(name="smoke", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="smoke_packs", in="formData", type="string", pattern="^[0-9]{1,2}$"),
     *     @SWG\Parameter(name="tobacco", in="formData", type="string", pattern="^(:?Yes|No)$"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
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
     *     path="/social-histories/{id}",
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
