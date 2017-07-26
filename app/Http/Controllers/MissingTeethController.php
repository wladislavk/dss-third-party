<?php

namespace DentalSleepSolutions\Http\Controllers;

class MissingTeethController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/missing-teeth",
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
     *                         @SWG\Items(ref="#/definitions/MissingTooth")
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
     *     path="/missing-teeth/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/MissingTooth")
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
     *     path="/missing-teeth",
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="pck", in="formData", type="string", pattern="^(?:~[0-9]*)+$"),
     *     @SWG\Parameter(name="rec", in="formData", type="string", pattern="^(?:~[0-9]*)+$"),
     *     @SWG\Parameter(name="mob", in="formData", type="string", pattern="^(?:~[0-9]*)+$"),
     *     @SWG\Parameter(name="rec1", in="formData", type="string", pattern="^(?:~[0-9]*)+$"),
     *     @SWG\Parameter(name="pck1", in="formData", type="string", pattern="^(?:~[0-9]*)+$"),
     *     @SWG\Parameter(name="s1", in="formData", type="integer"),
     *     @SWG\Parameter(name="s2", in="formData", type="integer"),
     *     @SWG\Parameter(name="s3", in="formData", type="integer"),
     *     @SWG\Parameter(name="s4", in="formData", type="integer"),
     *     @SWG\Parameter(name="s5", in="formData", type="integer"),
     *     @SWG\Parameter(name="s6", in="formData", type="integer"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/MissingTooth")
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
     *     path="/missing-teeth/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="pck", in="formData", type="string", pattern="^(?:~[0-9]*)+$"),
     *     @SWG\Parameter(name="rec", in="formData", type="string", pattern="^(?:~[0-9]*)+$"),
     *     @SWG\Parameter(name="mob", in="formData", type="string", pattern="^(?:~[0-9]*)+$"),
     *     @SWG\Parameter(name="rec1", in="formData", type="string", pattern="^(?:~[0-9]*)+$"),
     *     @SWG\Parameter(name="pck1", in="formData", type="string", pattern="^(?:~[0-9]*)+$"),
     *     @SWG\Parameter(name="s1", in="formData", type="integer"),
     *     @SWG\Parameter(name="s2", in="formData", type="integer"),
     *     @SWG\Parameter(name="s3", in="formData", type="integer"),
     *     @SWG\Parameter(name="s4", in="formData", type="integer"),
     *     @SWG\Parameter(name="s5", in="formData", type="integer"),
     *     @SWG\Parameter(name="s6", in="formData", type="integer"),
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
     *     path="/missing-teeth/{id}",
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

    public function getSingular()
    {
        return 'MissingTooth';
    }
}
