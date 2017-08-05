<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalUserRepository;
use DentalSleepSolutions\StaticClasses\ApiResponse;

class ExternalUsersController extends BaseRestController
{
    /** @var ExternalUserRepository */
    protected $repository;

    /**
     * @SWG\Get(
     *     path="/external-user",
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
     *                         @SWG\Items(ref="#/definitions/ExternalUser")
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
     *     path="/external-user/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/ExternalUser")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @todo: this implementation is not RESTful
     */
    public function show($id)
    {
        $resource = $this->repository->findFirstById($id);
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * @SWG\Post(
     *     path="/external-user",
     *     @SWG\Parameter(name="user_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="api_key", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="valid_from", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="valid_to", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="enabled", in="formData", type="boolean", required=true),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/ExternalUser")
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
        $this->validate($this->request, $this->request->storeRules());
        $data = $this->request->all();

        $data['created_by'] = $this->currentAdmin->adminid;
        $resource = $this->repository->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * @SWG\Put(
     *     path="/external-user/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="user_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="api_key", in="formData", type="string"),
     *     @SWG\Parameter(name="valid_from", in="formData", type="string"),
     *     @SWG\Parameter(name="valid_to", in="formData", type="string"),
     *     @SWG\Parameter(name="enabled", in="formData", type="boolean"),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @todo: this implementation is not RESTful
     */
    public function update($id)
    {
        $resource = $this->repository->findFirstById($id);
        $data = $this->request->all();

        $data['updated_by'] = $this->currentAdmin->adminid;
        $resource->update($data);

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * @SWG\Delete(
     *     path="/external-user/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="Resource deleted", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @todo: this implementation is not RESTful
     */
    public function destroy($id)
    {
        $resource = $this->repository->findFirstById($id);
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
