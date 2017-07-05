<?php

namespace DentalSleepSolutions\Http\Controllers;

class AdminsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/admins",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/Admin"))
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return parent::index();
    }

    /**
     * @SWG\Get(
     *     path="/admins/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Admin"))
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return parent::show($id);
    }

    /**
     * @SWG\Post(
     *     path="/admins",
     *     @SWG\Parameter(name="name", in="formData", type="string", maxLength="250"),
     *     @SWG\Parameter(name="username", in="formData", type="string", required=true, maxLength="250"),
     *     @SWG\Parameter(name="password", in="formData", type="string", required=true, maxLength="250"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="admin_access", in="formData", type="integer"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email", maxLength="100"),
     *     @SWG\Parameter(name="first_name", in="formData", type="string", maxLength="50"),
     *     @SWG\Parameter(name="last_name", in="formData", type="string", maxLength="50"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Admin"))
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        return parent::store();
    }

    /**
     * @SWG\Put(
     *     path="/admins/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="name", in="formData", type="string", maxLength="250"),
     *     @SWG\Parameter(name="username", in="formData", type="string", maxLength="250"),
     *     @SWG\Parameter(name="password", in="formData", type="string", maxLength="250"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="admin_access", in="formData", type="integer"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email", maxLength="100"),
     *     @SWG\Parameter(name="first_name", in="formData", type="string", maxLength="50"),
     *     @SWG\Parameter(name="last_name", in="formData", type="string", maxLength="50"),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        return parent::update($id);
    }

    /**
     * @SWG\Delete(
     *     path="/admins/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="Resource deleted", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return parent::destroy($id);
    }

    public function getModelNamespace()
    {
        return self::BASE_MODEL_NAMESPACE;
    }
}
