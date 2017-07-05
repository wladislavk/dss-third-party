<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;

class LoginDetailsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/login-details",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/LoginDetail"))
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
     *     path="/login-details/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/LoginDetail"))
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
     *     path="/login-details",
     *     @SWG\Parameter(name="loginid", in="formData", type="integer"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="cur_page", in="formData", type="string", required=true),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/LoginDetail"))
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function store()
    {
        $loginId = 0;
        $userId = 0;
        if ($this->currentUser) {
            $loginId = intval($this->currentUser->loginid);
            $userId = intval($this->currentUser->id);
        }

        $data = array_merge($this->request->all(), [
            'loginid'    => $loginId,
            'userid'     => $userId,
            'ip_address' => $this->request->ip(),
        ]);

        $resource = $this->resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * @SWG\Put(
     *     path="/login-details/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="loginid", in="formData", type="integer"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="cur_page", in="formData", type="string"),
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
     *     path="/login-details/{id}",
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
