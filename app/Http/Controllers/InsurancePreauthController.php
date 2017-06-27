<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Resources\InsurancePreauth;
use DentalSleepSolutions\Contracts\Repositories\InsurancePreauth as InsPreauth;
use Illuminate\Http\Request;

class InsurancePreauthController extends BaseRestController
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
        $this->hasIp = false;
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

    public function getSingular()
    {
        return 'InsurancePreauth';
    }
}
