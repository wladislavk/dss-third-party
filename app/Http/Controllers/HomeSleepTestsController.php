<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\HomeSleepTest;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\Request;

class HomeSleepTestsController extends BaseRestController
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
        return parent::store();
    }

    public function update($id)
    {
        return parent::update($id);
    }

    public function destroy($id)
    {
        return parent::destroy($id);
    }

    public function getUncompleted(HomeSleepTest $resources, Request $request)
    {
        $patientId = $request->input('patientId', 0);

        $data = $resources->getUncompleted($patientId);

        return ApiResponse::responseOk('', $data);
    }

    public function getByType($type, HomeSleepTest $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        switch ($type) {
            case 'completed':
                $data = $resources->getCompleted($docId);
                break;
            case 'requested':
                $data = $resources->getRequested($docId);
                break;
            case 'rejected':
                $data = $resources->getRejected($docId);
                break;
            default:
                $data = [];
                break;
        }

        return ApiResponse::responseOk('', $data);
    }
}
