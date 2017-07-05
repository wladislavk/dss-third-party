<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Resources\Company;
use DentalSleepSolutions\Contracts\Repositories\Companies;

class CompaniesController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/companies",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/Company"))
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
     *     path="/companies/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Company"))
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
     *     path="/companies",
     *     @SWG\Parameter(name="name", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string"),
     *     @SWG\Parameter(name="state", in="formData", type="string"),
     *     @SWG\Parameter(name="zip", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="default_new", in="formData", type="integer"),
     *     @SWG\Parameter(name="free_fax", in="formData", type="integer"),
     *     @SWG\Parameter(name="company_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="plan_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="use_support", in="formData", type="integer"),
     *     @SWG\Parameter(name="exclusive", in="formData", type="integer"),
     *     @SWG\Parameter(name="vob_require_test", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Company"))
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
     *     path="/companies/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="name", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string"),
     *     @SWG\Parameter(name="state", in="formData", type="string"),
     *     @SWG\Parameter(name="zip", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="default_new", in="formData", type="integer"),
     *     @SWG\Parameter(name="free_fax", in="formData", type="integer"),
     *     @SWG\Parameter(name="company_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="plan_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="use_support", in="formData", type="integer"),
     *     @SWG\Parameter(name="exclusive", in="formData", type="integer"),
     *     @SWG\Parameter(name="vob_require_test", in="formData", type="integer"),
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
     *     path="/companies/{id}",
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

    public function getCompanyLogo(Company $resource)
    {
        $userId = $this->currentUser->id ?: 0;

        $data = $resource->getCompanyLogo($userId);

        return ApiResponse::responseOk('', $data);
    }

    public function getHomeSleepTestCompanies(Companies $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getHomeSleepTestCompanies($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getBillingExclusiveCompany(Company $resource)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resource->getBillingExclusiveCompany($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getModelNamespace()
    {
        return self::BASE_MODEL_NAMESPACE;
    }
}
