<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerHistoryRepository;
use DentalSleepSolutions\Facades\ApiResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * @todo: restore API tests if needed or delete the controller
 */
class LedgerHistoriesController extends BaseRestController
{
    /** @var LedgerHistoryRepository */
    protected $repository;

    /**
     * @SWG\Get(
     *     path="/ledger-histories",
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
     *                         @SWG\Items(ref="#/definitions/LedgerHistory")
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
     *     path="/ledger-histories/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/LedgerHistory")
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
     *     path="/ledger-histories",
     *     @SWG\Parameter(name="ledgerid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="service_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="entry_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="description", in="formData", type="string"),
     *     @SWG\Parameter(name="producer", in="formData", type="string"),
     *     @SWG\Parameter(name="amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="transaction_type", in="formData", type="string"),
     *     @SWG\Parameter(name="paid_amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="transaction_code", in="formData", type="string", pattern="^[A-Z][0-9]{4}$"),
     *     @SWG\Parameter(name="placeofservice", in="formData", type="string"),
     *     @SWG\Parameter(name="emg", in="formData", type="string"),
     *     @SWG\Parameter(name="diagnosispointer", in="formData", type="string"),
     *     @SWG\Parameter(name="daysorunits", in="formData", type="string"),
     *     @SWG\Parameter(name="epsdt", in="formData", type="string"),
     *     @SWG\Parameter(name="idqual", in="formData", type="string"),
     *     @SWG\Parameter(name="modcode", in="formData", type="string"),
     *     @SWG\Parameter(name="producerid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="primary_claim_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="primary_paper_claim_id", in="formData", type="string"),
     *     @SWG\Parameter(name="modcode2", in="formData", type="string"),
     *     @SWG\Parameter(name="modcode3", in="formData", type="string"),
     *     @SWG\Parameter(name="modcode4", in="formData", type="string"),
     *     @SWG\Parameter(name="percase_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="percase_name", in="formData", type="string"),
     *     @SWG\Parameter(name="percase_amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="percase_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="percase_invoice", in="formData", type="integer"),
     *     @SWG\Parameter(name="percase_free", in="formData", type="integer"),
     *     @SWG\Parameter(name="updated_by_user", in="formData", type="integer"),
     *     @SWG\Parameter(name="updated_by_admin", in="formData", type="integer"),
     *     @SWG\Parameter(name="primary_claim_history_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="secondary_claim_id", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/LedgerHistory")
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
        $data = array_merge($this->request->all(), [
            'ip_address' => $this->request->ip(),
            'adddate'    => Carbon::now()->format('m/d/Y'),
        ]);

        $resource = $this->repository->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * @SWG\Put(
     *     path="/ledger-histories/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="ledgerid", in="formData", type="integer"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="service_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="entry_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="description", in="formData", type="string"),
     *     @SWG\Parameter(name="producer", in="formData", type="string"),
     *     @SWG\Parameter(name="amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="transaction_type", in="formData", type="string"),
     *     @SWG\Parameter(name="paid_amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="transaction_code", in="formData", type="string", pattern="^[A-Z][0-9]{4}$"),
     *     @SWG\Parameter(name="placeofservice", in="formData", type="string"),
     *     @SWG\Parameter(name="emg", in="formData", type="string"),
     *     @SWG\Parameter(name="diagnosispointer", in="formData", type="string"),
     *     @SWG\Parameter(name="daysorunits", in="formData", type="string"),
     *     @SWG\Parameter(name="epsdt", in="formData", type="string"),
     *     @SWG\Parameter(name="idqual", in="formData", type="string"),
     *     @SWG\Parameter(name="modcode", in="formData", type="string"),
     *     @SWG\Parameter(name="producerid", in="formData", type="integer"),
     *     @SWG\Parameter(name="primary_claim_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="primary_paper_claim_id", in="formData", type="string"),
     *     @SWG\Parameter(name="modcode2", in="formData", type="string"),
     *     @SWG\Parameter(name="modcode3", in="formData", type="string"),
     *     @SWG\Parameter(name="modcode4", in="formData", type="string"),
     *     @SWG\Parameter(name="percase_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="percase_name", in="formData", type="string"),
     *     @SWG\Parameter(name="percase_amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="percase_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="percase_invoice", in="formData", type="integer"),
     *     @SWG\Parameter(name="percase_free", in="formData", type="integer"),
     *     @SWG\Parameter(name="updated_by_user", in="formData", type="integer"),
     *     @SWG\Parameter(name="updated_by_admin", in="formData", type="integer"),
     *     @SWG\Parameter(name="primary_claim_history_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="secondary_claim_id", in="formData", type="integer"),
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
     *     path="/ledger-histories/{id}",
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
     *     path="/ledger-histories/ledger-report",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHistoriesForLedgerReport(Request $request)
    {
        $patientId = $request->input('patient_id', 0);
        $ledgerId = $request->input('ledger_id', 0);
        $type = $request->input('type', 'ledger');

        $data = $this->repository->getHistoriesForLedgerReport($this->user->docid, $patientId, $ledgerId, $type);

        return ApiResponse::responseOk('', $data);
    }
}
