<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\EdxCertificateRepository;
use DentalSleepSolutions\Facades\ApiResponse;
use Illuminate\Http\JsonResponse;

class EdxCertificatesController extends BaseRestController
{
    /** @var EdxCertificateRepository */
    protected $repository;

    /**
     * @SWG\Get(
     *     path="/edx-certificates",
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
     *                         @SWG\Items(ref="#/definitions/EdxCertificate")
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
     *     path="/edx-certificates/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/EdxCertificate")
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
     *     path="/edx-certificates",
     *     @SWG\Parameter(name="url", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="edx_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="course_name", in="formData", type="string"),
     *     @SWG\Parameter(name="course_section", in="formData", type="string"),
     *     @SWG\Parameter(name="course_subsection", in="formData", type="string"),
     *     @SWG\Parameter(name="number_ce", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/EdxCertificate")
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
     *     path="/edx-certificates/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="url", in="formData", type="string"),
     *     @SWG\Parameter(name="edx_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="course_name", in="formData", type="string"),
     *     @SWG\Parameter(name="course_section", in="formData", type="string"),
     *     @SWG\Parameter(name="course_subsection", in="formData", type="string"),
     *     @SWG\Parameter(name="number_ce", in="formData", type="integer"),
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
     *     path="/edx-certificates/{id}",
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
     * @SWG\Get(
     *     path="/edx-certificates/by-user",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByUser(): JsonResponse
    {
        $certificates = $this->repository->getByUserId($this->user()->userid);
        return ApiResponse::responseOk('', $certificates);
    }

    public function getModelNamespace()
    {
        return self::BASE_MODEL_NAMESPACE;
    }
}
