<?php

namespace DentalSleepSolutions\Http\Controllers;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\Insurance;
use DentalSleepSolutions\Eloquent\Models\Dental\Ledger;
use DentalSleepSolutions\Eloquent\Models\Dental\LedgerNote;
use DentalSleepSolutions\Eloquent\Models\Dental\LedgerStatement;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\PatientSummary;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientSummaryRepository;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\Request;

class LedgersController extends BaseRestController
{
    // Transaction types (ledger)
    const DSS_TRXN_TYPE_MED = 1;
    const DSS_TRXN_TYPE_PATIENT = 2;
    const DSS_TRXN_TYPE_INS = 3;
    const DSS_TRXN_TYPE_DIAG = 4;
    const DSS_TRXN_TYPE_ADJ = 6;

    // Transaction Payment Types (ledger)
    const DSS_TRXN_PYMT_CREDIT = 0;
    const DSS_TRXN_PYMT_DEBIT = 1;
    const DSS_TRXN_PYMT_CHECK = 2;
    const DSS_TRXN_PYMT_CASH = 3;
    const DSS_TRXN_PYMT_WRITEOFF = 4;
    const DSS_TRXN_PYMT_EFT = 5;

    // Transaction Payers (ledger)
    const DSS_TRXN_PAYER_PRIMARY = 0;
    const DSS_TRXN_PAYER_SECONDARY = 1;
    const DSS_TRXN_PAYER_PATIENT = 2;
    const DSS_TRXN_PAYER_WRITEOFF = 3;
    const DSS_TRXN_PAYER_DISCOUNT = 4;

    private $dssTransactionPaymentTypeLabels = [
        self::DSS_TRXN_PYMT_CREDIT   => "Credit Card",
        self::DSS_TRXN_PYMT_DEBIT    => "Debit",
        self::DSS_TRXN_PYMT_CHECK    => "Check",
        self::DSS_TRXN_PYMT_CASH     => "Cash",
        self::DSS_TRXN_PYMT_WRITEOFF => "Write Off",
        self::DSS_TRXN_PYMT_EFT      => "E-Funds Transfer (EFT)"
    ];

    private $dssTransactionPayerLabels = [
        self::DSS_TRXN_PAYER_PRIMARY   => "Primary Insurance",
        self::DSS_TRXN_PAYER_SECONDARY => "Secondary Insurance",
        self::DSS_TRXN_PAYER_PATIENT   => "Patient",
        self::DSS_TRXN_PAYER_WRITEOFF  => "Write Off",
        self::DSS_TRXN_PAYER_DISCOUNT  => "Professional Discount",
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
     * @param Patient $patientResource
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListOfLedgerRows(
        Patient $patientResource,
        Request $request
    ) {
        $docId = $this->currentUser->docid ?: 0;

        $reportType = $request->input('report_type', 'today');
        $page = $request->input('page', 0);
        $rowsPerPage = $request->input('rows_per_page', 20);
        $sort = $request->input('sort');
        $sortDir = $request->input('sort_dir', 'asc');

        if ($reportType === 'today') {
            $ledgerRows = $this->repository->getTodayList($docId, $page, $rowsPerPage, $sort, $sortDir);
        } else {
            $ledgerRows = $this->repository->getFullList($docId, $page, $rowsPerPage, $sort, $sortDir);
        }

        if ($ledgerRows['total'] > 0) {
            $ledgerRows['result']->map(function ($row) use ($patientResource) {
                $patients = $patientResource->getWithFilter(['firstname', 'lastname'], [
                    'patientid' => $row->patientid
                ]);

                $row['patient_info'] = count($patients) > 0 ? $patients[0] : null;

                return $row;
            });
        }

        return ApiResponse::responseOk('', $ledgerRows);
    }

    /**
     * @SWG\Post(
     *     path="/ledgers/totals",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReportTotals(Request $request)
    {
        $docId = $this->currentUser->docid ?: 0;

        $reportType = $request->input('report_type', 'today');
        $patientId = $request->input('patient_id', 0);

        $totals = [
            'charges'     => $this->repository->getTotalCharges($docId, $reportType, $patientId),
            'credits'     => $this->repository->getTotalCredits($docId, $reportType, $patientId),
            'adjustments' => $this->repository->getTotalAdjustments($docId, $reportType, $patientId),
        ];

        if ($reportType == 'full') {
            $totals['credits']['type']->map(function ($row) {
                $description = $this->dssTransactionPaymentTypeLabels[$row['payment_description']];

                $description = preg_match('/^checks?$/i', $description) ? 'Checks' : $description;

                switch ($row['payment_payer']) {
                    case self::DSS_TRXN_PAYER_PRIMARY:
                        // fall through
                    case self::DSS_TRXN_PAYER_SECONDARY:
                        $description = 'Ins. ' . $description;
                        break;

                    case self::DSS_TRXN_PAYER_PATIENT:
                        $description = 'Pt. ' . $description;
                        break;

                    case self::DSS_TRXN_PAYER_WRITEOFF:
                        $description = $this->dssTransactionPayerLabels[self::DSS_TRXN_PAYER_WRITEOFF];
                        break;
                }

                $row['payment_description'] = $description;

                return $row;
            });

            $totals['credits']['named']->map(function ($row) {
                $description = strlen(trim($row['payment_description'])) ? trim($row['payment_description']) : 'Unlabelled transaction type';

                $description = preg_match('/^checks?$/i', $description) ? 'Checks' : $description;

                switch ($row['payment_type']) {
                    case self::DSS_TRXN_TYPE_INS:
                        $description = 'Ins. ' . $description;
                        break;
                    case self::DSS_TRXN_TYPE_PATIENT:
                        $description = 'Pt. ' . $description;
                        break;
                }

                $row['payment_description'] = $description;

                return $row;
            });
        }

        return ApiResponse::responseOk('', $totals);
    }

    /**
     * @SWG\Post(
     *     path="/ledgers/update-patient-summary",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @param PatientSummaryRepository $patientSummaryRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePatientSummary(
        Request $request,
        PatientSummaryRepository $patientSummaryRepository
    ) {
        $docId = $this->currentUser->docid ?: 0;

        $patientId = $request->input('patient_id', 0);

        $patientSummary = $patientSummaryRepository->getPatientInfo($patientId);

        $ifPatientSummaryExists = false;
        $ledgerBalance = 0;

        if (!empty($patientSummary)) {
            $rowsForCountingLedgerBalance = $this->repository->getRowsForCountingLedgerBalance($docId, $patientId);

            if (count($rowsForCountingLedgerBalance)) {
                foreach ($rowsForCountingLedgerBalance as $row) {
                    $ledgerBalance -= !empty($row->amount) ? $row->amount : 0;
                    $ledgerBalance += !empty($row->paid_amount) ? $row->paid_amount : 0;
                }
            }

            $patientSummaryRepository->updatePatientSummary($patientId, ['ledger' => $ledgerBalance]);
            $ifPatientSummaryExists = true;
        } else {
            $patientSummaryRepository->create([
                'pid'    => $patientId,
                'ledger' => $ledgerBalance,
            ]);
        }

        $response = 'Patient Summary was successfully inserted.';
        if ($ifPatientSummaryExists) {
            $response = 'Patient Summary was successfully updated.';
        }

        return ApiResponse::responseOk($response);
    }

    /**
     * @SWG\Post(
     *     path="/ledgers/report-data",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @param Insurance $insurance
     * @param LedgerNote $ledgerNote
     * @param LedgerStatement $ledgerStatement
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReportData(
        Request $request,
        Insurance $insurance,
        LedgerNote $ledgerNote,
        LedgerStatement $ledgerStatement
    ) {
        $docId = $this->currentUser->docid ?: 0;

        $patientId = $request->input('patient_id', 0);
        $page = $request->input('page', 0);
        $rowsPerPage = $request->input('rows_per_page', 20);
        $sort = $request->input('sort');
        $sortDir = $request->input('sort_dir', 'asc');
        $openClaims = $request->input('open_claims', false);

        if ($openClaims) {
            $data = $insurance->getOpenClaims($patientId, $page, $rowsPerPage, $sort, $sortDir);
        } else {
            $data = $this->repository->getReportData($ledgerNote, $ledgerStatement, $insurance, [
                'doc_id'        => $docId,
                'patient_id'    => $patientId,
                'page'          => $page,
                'rows_per_page' => $rowsPerPage,
                'sort'          => $sort,
                'sort_dir'      => $sortDir,
            ]);
        }

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/ledgers/report-rows-number",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @param Insurance $insurance
     * @param LedgerNote $ledgerNote
     * @param LedgerStatement $ledgerStatement
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReportRowsNumber(
        Request $request,
        Insurance $insurance,
        LedgerNote $ledgerNote,
        LedgerStatement $ledgerStatement
    ) {
        $docId = $this->currentUser->docid ?: 0;

        $patientId = $request->input('patient_id', 0);

        $number = $this->repository->getReportRowsNumber($ledgerNote, $ledgerStatement, $insurance, $docId, $patientId);

        return ApiResponse::responseOk('', ['number' => $number]);
    }
}
