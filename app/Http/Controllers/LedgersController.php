<?php

namespace DentalSleepSolutions\Http\Controllers;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Helpers\LedgerReportDataRetriever;
use DentalSleepSolutions\Helpers\LedgerReportTotalsRetriever;
use DentalSleepSolutions\Helpers\LedgerRowsRetriever;
use DentalSleepSolutions\Helpers\PatientSummaryUpdater;
use DentalSleepSolutions\Helpers\QueryComposers\LedgersQueryComposer;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Structs\LedgerReportData;
use Illuminate\Http\Request;

class LedgersController extends BaseRestController
{
    const REPORT_TYPE_TODAY = 'today';
    const REPORT_TYPE_FULL = 'full';
    const REPORT_TYPES = [
        self::REPORT_TYPE_TODAY,
        self::REPORT_TYPE_FULL,
    ];

    /** @var LedgerRepository */
    protected $repository;

    /**
     * @SWG\Get(
     *     path="/ledgers",
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
     *                         @SWG\Items(ref="#/definitions/Ledger")
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
     *     path="/ledgers/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Ledger")
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
     *     path="/ledgers",
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
     *     @SWG\Parameter(name="secondary_claim_id", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Ledger")
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
        // The `adddate` field must be changed to correct date format.
        // A certain setter should be moved to the model.
        // Now the field has the `varchar` type and `m/d/Y` date format.

        $data = array_merge($this->request->all(), [
            'ip_address' => $this->request->ip(),
            'adddate'    => Carbon::now()->format('m/d/Y'),
        ]);

        $resource = $this->repository->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * @SWG\Put(
     *     path="/ledgers/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
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
     *     path="/ledgers/{id}",
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
     *     path="/ledgers/list",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @param LedgerRowsRetriever $ledgerRowsRetriever
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListOfLedgerRows(
        Request $request,
        LedgerRowsRetriever $ledgerRowsRetriever
    ) {
        $ledgerReportData = new LedgerReportData();

        $ledgerReportData->docId = $this->currentUser->getDocIdOrZero();
        $ledgerReportData->page = $request->input('page', 0);
        $ledgerReportData->rowsPerPage = $request->input('rows_per_page', 20);
        $ledgerReportData->sort = $request->input('sort');
        $ledgerReportData->sortDir = $request->input('sort_dir', 'asc');

        $reportType = $request->input('report_type', self::REPORT_TYPE_TODAY);

        $ledgerRows = $ledgerRowsRetriever->getLedgerRows($ledgerReportData, $reportType);

        return ApiResponse::responseOk('', $ledgerRows);
    }

    /**
     * @SWG\Post(
     *     path="/ledgers/totals",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @param LedgerReportTotalsRetriever $ledgerReportTotalsRetriever
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReportTotals(Request $request, LedgerReportTotalsRetriever $ledgerReportTotalsRetriever)
    {
        $docId = $this->currentUser->getDocIdOrZero();
        $patientId = $request->input('patient_id', 0);
        $reportType = $request->input('report_type', self::REPORT_TYPE_TODAY);

        $totals = $ledgerReportTotalsRetriever->getReportTotals($docId, $patientId, $reportType);

        return ApiResponse::responseOk('', $totals->toArray());
    }

    /**
     * @SWG\Post(
     *     path="/ledgers/update-patient-summary",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @param PatientSummaryUpdater $patientSummaryUpdater
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePatientSummary(
        Request $request,
        PatientSummaryUpdater $patientSummaryUpdater
    ) {
        $docId = $this->currentUser->getDocIdOrZero();
        $patientId = $request->input('patient_id', 0);

        $response = $patientSummaryUpdater->updatePatientSummary($docId, $patientId);

        return ApiResponse::responseOk($response);
    }

    /**
     * @SWG\Post(
     *     path="/ledgers/report-data",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @param LedgerReportDataRetriever $ledgerReportDataRetriever
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReportData(
        Request $request,
        LedgerReportDataRetriever $ledgerReportDataRetriever
    ) {
        $ledgerReportData = new LedgerReportData();

        $ledgerReportData->docId = $this->currentUser->getDocIdOrZero();
        $ledgerReportData->patientId = $request->input('patient_id', 0);
        $ledgerReportData->page = $request->input('page', 0);
        $ledgerReportData->rowsPerPage = $request->input('rows_per_page', 20);
        $ledgerReportData->sort = $request->input('sort', '');
        $ledgerReportData->sortDir = $request->input('sort_dir', 'asc');

        $openClaims = $request->input('open_claims', false);

        $data = $ledgerReportDataRetriever->getReportData($ledgerReportData, $openClaims);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/ledgers/report-rows-number",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @param LedgersQueryComposer $ledgersQueryComposer
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReportRowsNumber(Request $request, LedgersQueryComposer $ledgersQueryComposer)
    {
        $docId = $this->currentUser->getDocIdOrZero();

        $patientId = $request->input('patient_id', 0);

        $number = $ledgersQueryComposer->getReportRowsNumber($docId, $patientId);

        return ApiResponse::responseOk('', ['number' => $number]);
    }
}
