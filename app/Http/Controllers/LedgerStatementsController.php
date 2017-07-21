<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerStatement;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerStatementRepository;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\Request;

class LedgerStatementsController extends BaseRestController
{
    /** @var LedgerStatementRepository */
    protected $repository;

    /**
     * @SWG\Get(
     *     path="/ledger-statements",
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
     *                         @SWG\Items(ref="#/definitions/LedgerStatement")
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
     *     path="/ledger-statements/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/LedgerStatement")
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
     *     path="/ledger-statements",
     *     @SWG\Parameter(name="producerid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="filename", in="formData", type="string", pattern="^\/manage\/letterpdfs\/statement_[0-9]+_[0-9]+\.pdf$"),
     *     @SWG\Parameter(name="service_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="entry_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/LedgerStatement")
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
     *     path="/ledger-statements/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="producerid", in="formData", type="integer"),
     *     @SWG\Parameter(name="filename", in="formData", type="string", pattern="^\/manage\/letterpdfs\/statement_[0-9]+_[0-9]+\.pdf$"),
     *     @SWG\Parameter(name="service_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="entry_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
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
     *     path="/ledger-statements/{id}",
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
     *     path="/ledger-statements/remove",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeByIdAndPatientId(Request $request)
    {
        $id = $request->input('id', 0);
        $patientId = $request->input('patient_id', 0);

        $this->repository->removeByIdAndPatientId($id, $patientId);

        return ApiResponse::responseOk('Resource deleted');
    }
}
