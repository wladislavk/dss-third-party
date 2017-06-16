<?php

namespace DentalSleepSolutions\Http\Controllers;

use Carbon\Carbon;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\Faxes;

class FaxesController extends Controller
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
            'sent_date'  => Carbon::now(),
            'ip_address' => $this->request->ip(),
        ]);

        $resource = $this->resources->create($data);

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

    public function getAlerts(Faxes $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getAlerts($docId);

        return ApiResponse::responseOk('', $data);
    }
}
