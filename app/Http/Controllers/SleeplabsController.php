<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Resources\Sleeplab;
use DentalSleepSolutions\Contracts\Repositories\Sleeplabs;
use DentalSleepSolutions\Contracts\Repositories\Patients;
use Illuminate\Http\Request;

class SleeplabsController extends BaseRestController
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

    public function getListOfSleeplabs(
        Sleeplabs $resources,
        Patients $patientResource,
        Request $request
    ) {
        $docId = $this->currentUser->docid ?: 0;

        $page = $request->input('page', 0);
        $rowsPerPage = $request->input('rows_per_page', 20);
        $sort = $request->input('sort');
        $sortDir = $request->input('sort_dir', 'asc');
        $letter = $request->input('letter');

        $sleeplabs = $resources->getList($docId, $page, $rowsPerPage, $sort, $sortDir, $letter);

        if ($sleeplabs['total'] > 0) {
            $sleeplabs['result']->map(function ($sleeplab) use ($patientResource) { 
                $sleeplab['patients'] = $patientResource->getRelatedToSleeplab($sleeplab->sleeplabid);
            
                return $sleeplab;
            });
        }

        return ApiResponse::responseOk('', $sleeplabs);
    }

    public function editSleeplab(
        Sleeplab $sleeplabResource,
        Request $request,
        $sleeplabId = null
    ) {
        $docId = $this->currentUser->docid ?: 0;

        $sleeplabFormData = $request->input('sleeplab_form_data', []);

        if ($sleeplabId) {
            $validator = $this->getValidationFactory()->make(
                $sleeplabFormData, (new \DentalSleepSolutions\Http\Requests\Sleeplab())->updateRules()
            );
        } else {
            $validator = $this->getValidationFactory()->make(
                $sleeplabFormData, (new \DentalSleepSolutions\Http\Requests\Sleeplab())->storeRules()
            );
        }

        if ($validator->fails()) {
            return ApiResponse::responseError('', 422, $validator->messages());
        }
        if (count($sleeplabFormData) == 0) {
            return ApiResponse::responseError('Sleeplab data is empty.', 422);
        }

        $sleeplabFormData = array_merge($sleeplabFormData, [
            'docid' => $docId,
            'ip_address' => $request->ip(),
        ]);

        $responseData = [];
        if ($sleeplabId) {
            $sleeplabResource->updateSleeplab($sleeplabId, $sleeplabFormData);

            $responseData['status'] = 'Edited Successfully';
        } else { // sleeplabId = 0 -> creating a new sleeplab
            $sleeplabResource->create($sleeplabFormData);

            $responseData['status'] = 'Added Successfully';
        }

        return ApiResponse::responseOk('', $responseData);
    }
}
