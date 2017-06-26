<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;

class ExternalCompaniesController extends BaseRestController
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
        $this->validate($this->request, $this->request->storeRules());
        $data = $this->request->all();

        /**
         * @ToDo: Handle admin tokens
         * @see AWS-19-Request-Token
         */
        $data['created_by'] = $this->currentUser->id;
        $resource = $this->resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    public function update($id)
    {
        $this->validate($this->request, $this->request->updateRules());
        /** @var Resource $resource */
        $resource = $this->resources->findOrFail($id);
        $data = $this->request->all();
        /**
         * @ToDo: Handle admin tokens
         * @see AWS-19-Request-Token
         */
        $data['updated_by'] = $this->currentUser->id;
        $resource->update($data);

        return ApiResponse::responseOk('Resource updated');
    }

    public function destroy($id)
    {
        return parent::destroy($id);
    }
}
