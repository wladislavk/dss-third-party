<?php

namespace DentalSleepSolutions\Http\Controllers;

use Carbon\Carbon;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\Ledgers;
use DentalSleepSolutions\Contracts\Resources\Patient;
use DentalSleepSolutions\Contracts\Resources\PatientSummary;
use DentalSleepSolutions\Contracts\Repositories\Insurances;
use DentalSleepSolutions\Contracts\Repositories\LedgerNotes;
use DentalSleepSolutions\Contracts\Repositories\LedgerStatements;
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
        self::DSS_TRXN_PAYER_DISCOUNT  => "Professional Discount"
    ];

    /**
     * @SWG\Get(
     *     path="/ledgers",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/Ledger"))
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
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Ledger"))
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
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Ledger"))
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

        $resource = $this->resources->create($data);

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

    public function getListOfLedgerRows(
        Ledgers $resources,
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
            $ledgerRows = $resources->getTodayList($docId, $page, $rowsPerPage, $sort, $sortDir);
        } else {
            $ledgerRows = $resources->getFullList($docId, $page, $rowsPerPage, $sort, $sortDir);
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

    public function getReportTotals(Ledgers $resources, Request $request)
    {
        $docId = $this->currentUser->docid ?: 0;

        $reportType = $request->input('report_type', 'today');
        $patientId = $request->input('patient_id', 0);

        $totals = [
            'charges'     => $resources->getTotalCharges($docId, $reportType, $patientId),
            'credits'     => $resources->getTotalCredits($docId, $reportType, $patientId),
            'adjustments' => $resources->getTotalAdjustments($docId, $reportType, $patientId)
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

    public function updatePatientSummary(
        Request $request,
        PatientSummary $patientSummary,
        Ledgers $ledger
    ) {
        $docId = $this->currentUser->docid ?: 0;

        $patientId = $request->input('patient_id', 0);

        $patientSummary = $patientSummary->getPatientInfo($patientId);

        $ifPatientSummaryExists = false;
        $ledgerBalance = 0;

        if (!empty($patientSummary)) {
            $rowsForCountingLedgerBalance = $ledger->getRowsForCountingLedgerBalance($docId, $patientId);

            if (count($rowsForCountingLedgerBalance) > 0) {
                foreach ($rowsForCountingLedgerBalance as $row) {
                    $ledgerBalance -= !empty($row->amount) ? $row->amount : 0;
                    $ledgerBalance += !empty($row->paid_amount) ? $row->paid_amount : 0;
                }
            }

            $patientSummary->updatePatientSummary($patientId, ['ledger' => $ledgerBalance]);
            $ifPatientSummaryExists = true;
        } else {
            $patientSummary->create([
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

    public function getReportData(
        Request $request,
        Insurances $insurance,
        Ledgers $ledger,
        LedgerNotes $ledgerNote,
        LedgerStatements $ledgerStatement
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
            $data = $ledger->getReportData($ledgerNote, $ledgerStatement, $insurance, [
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

    public function getReportRowsNumber(
        Request $request,
        Ledgers $ledger,
        Insurances $insurance,
        LedgerNotes $ledgerNote,
        LedgerStatements $ledgerStatement
    ) {
        $docId = $this->currentUser->docid ?: 0;

        $patientId = $request->input('patient_id', 0);

        $number = $ledger->getReportRowsNumber($ledgerNote, $ledgerStatement, $insurance, $docId, $patientId);

        return ApiResponse::responseOk('', ['number' => $number]);
    }
}
