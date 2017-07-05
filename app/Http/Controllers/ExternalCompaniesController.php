<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;

class ExternalCompaniesController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/external-companies",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/ExternalCompany"))
     *                 )
     *             )
     *         }
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
     *     path="/external-companies/{external_companies}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/ExternalCompany"))
     *             )
     *         }
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
     *     path="/external-companies",
     *     @SWG\Parameter(name="software", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="name", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="short_name", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="api_key", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="valid_from", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="valid_to", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="url", in="formData", type="string"),
     *     @SWG\Parameter(name="description", in="formData", type="string"),
     *     @SWG\Parameter(name="status", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="reason", in="formData", type="string"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/ExternalCompany"))
     *             )
     *         }
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function store()
    {
        $this->validate($this->request, $this->request->storeRules());
        $data = $this->request->all();

        /**
         * @ToDo: Handle admin tokens
         * @see AWS-19-Request-Token
         */
        $data['created_by'] = $this->currentUser->id;
        $resource = $this->resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * @SWG\Put(
     *     path="/external-companies/{external_companies}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="software", in="formData", type="string"),
     *     @SWG\Parameter(name="name", in="formData", type="string"),
     *     @SWG\Parameter(name="short_name", in="formData", type="string"),
     *     @SWG\Parameter(name="api_key", in="formData", type="string"),
     *     @SWG\Parameter(name="valid_from", in="formData", type="string"),
     *     @SWG\Parameter(name="valid_to", in="formData", type="string"),
     *     @SWG\Parameter(name="url", in="formData", type="string"),
     *     @SWG\Parameter(name="description", in="formData", type="string"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="reason", in="formData", type="string"),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function update($id)
    {
        $this->validate($this->request, $this->request->updateRules());
        /** @var Resource $resource */
        $resource = $this->resources->findOrFail($id);
        $data = $this->request->all();
        /**
         * @ToDo: Handle admin tokens
         * @see AWS-19-Request-Token
         */
        $data['updated_by'] = $this->currentUser->id;
        $resource->update($data);

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * @SWG\Delete(
     *     path="/external-companies/{external_companies}",
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
