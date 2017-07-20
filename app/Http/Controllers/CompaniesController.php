<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Company;
use DentalSleepSolutions\StaticClasses\ApiResponse;

class CompaniesController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/companies",
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
     *                         @SWG\Items(ref="#/definitions/Company")
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
     *     path="/companies/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Company")
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
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Company")
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

    /**
     * @SWG\Post(
     *     path="/companies/company-logo",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Company $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompanyLogo(Company $resource)
    {
        $userId = $this->currentUser->id ?: 0;

        $data = $resource->getCompanyLogo($userId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/companies/home-sleep-test",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Company $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHomeSleepTestCompanies(Company $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getHomeSleepTestCompanies($docId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/companies/billing-exclusive-company",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Company $resource
     * @return \Illuminate\Http\JsonResponse
     */
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
