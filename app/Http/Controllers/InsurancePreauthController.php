<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Requests\InsurancePreauthStore;
use DentalSleepSolutions\Http\Requests\InsurancePreauthUpdate;
use DentalSleepSolutions\Http\Requests\InsurancePreauthDestroy;
use DentalSleepSolutions\Contracts\Resources\InsurancePreauth;
use DentalSleepSolutions\Contracts\Repositories\InsurancePreauth as InsPreauth;
use Illuminate\Http\Request;

class InsurancePreauthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsPreauth $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(InsPreauth $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsurancePreauth $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(InsurancePreauth $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsPreauth $resources
     * @param  \DentalSleepSolutions\Http\Requests\InsurancePreauthStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InsPreauth $resources, InsurancePreauthStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsurancePreauth $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsurancePreauthUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InsurancePreauth $resource, InsurancePreauthUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsurancePreauth $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsurancePreauthDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(InsurancePreauth $resource, InsurancePreauthDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    public function getByType($type, InsPreauth $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        switch ($type) {
            case 'completed':
                $data = $resources->getCompleted($docId);
                break;
            case 'pending':
                $data = $resources->getPending($docId);
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

    public function getPendingVOBByContactId(InsurancePreauth $resource, Request $request)
    {
        $contactId = $request->input('contact_id', 0);
        $data = $resource->getPendingVOBByContactId($contactId);
      
        return ApiResponse::responseOk('', $data);
    }

    public function find(InsPreauth $resources, Request $request)
    {
        $docId = $this->currentUser->docid ?: 0;

        $pageNumber = $request->input('page');
        $vobsPerPage = $request->input('vobsPerPage');
        $sortColumn = $request->input('sortColumn');
        $sortDir = $request->input('sortDir');
        $viewed = $request->input('viewed');

        $data = $resources->getListVobs(
            $docId, 
            $viewed, 
            $sortColumn,
            $sortDir,
            $vobsPerPage,
            $pageNumber
        );

        return ApiResponse::responseOk('', $data);
    }
}
