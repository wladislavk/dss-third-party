<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\LedgerStore;
use DentalSleepSolutions\Http\Requests\LedgerUpdate;
use DentalSleepSolutions\Http\Requests\LedgerDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Ledger;
use DentalSleepSolutions\Contracts\Repositories\Ledgers;
use DentalSleepSolutions\Contracts\Resources\Patient;
use Illuminate\Http\Request;

use Carbon\Carbon;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class LedgersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Ledgers $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Ledgers $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Ledger $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Ledger $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Ledgers $resources
     * @param  \DentalSleepSolutions\Http\Requests\LedgerStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Ledgers $resources, LedgerStore $request)
    {
        // The `adddate` field must be changed to correct date format.
        // A certain setter should be moved to the model.
        // Now the field has the `varchar` type and `m/d/Y` date format.

        $data = array_merge($request->all(), [
            'ip_address' => $request->ip(),
            'adddate'    => Carbon::now()->format('m/d/Y')
        ]);

        $resource = $resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Ledger $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Ledger $resource, LedgerUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Ledger $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Ledger $resource, LedgerDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    public function getListOfLedgerRows(
        Ledgers $resources,
        Patient $patientResource,
        Request $request
    ) {
        $docId = $this->currentUser->docid ?: 0;

        $reportType = $request->input('report_type') ?: 'today';
        $page = $request->input('page') ?: 0;
        $rowsPerPage = $request->input('rows_per_page') ?: 20;
        $sort = $request->input('sort');
        $sortDir = $request->input('sort_dir') ?: 'asc';

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

        $reportType = $request->input('report_type') ?: 'today';
        $patientId = $request->input('patient_id') ?: 0;

        $totals = [
            'charges'     => $resources->getTotalCharges($docId, $reportType, $patientId),
            'credits'     => $resources->getTotalCredits($docId, $reportType, $patientId),
            'adjustments' => $resources->getTotalAdjustments($docId, $reportType, $patientId)
        ];

        return ApiResponse::responseOk('', $totals);
    }
}
