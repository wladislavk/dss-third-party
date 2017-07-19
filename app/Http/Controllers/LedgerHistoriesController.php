<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerHistory;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LedgerHistoriesController extends BaseRestController
{
    public function index()
    {
        return parent::index();
    }

    public function show($id)
    {
        return parent::show($id);
    }

    public function store()
    {
        $data = array_merge($this->request->all(), [
            'ip_address' => $this->request->ip(),
            'adddate'    => Carbon::now()->format('m/d/Y'),
        ]);

        $resource = $this->repository->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    public function update($id)
    {
        return parent::update($id);
    }

    public function destroy($id)
    {
        return parent::destroy($id);
    }

    public function getHistoriesForLedgerReport(LedgerHistory $resource, Request $request)
    {
        $docId = $this->currentUser->docid ?: 0;

        $patientId = $request->input('patient_id', 0);
        $ledgerId = $request->input('ledger_id', 0);
        $type = $request->input('type');

        $data = $resource->getHistoriesForLedgerReport($docId, $patientId, $ledgerId, $type);

        return ApiResponse::responseOk('', $data);
    }
}
