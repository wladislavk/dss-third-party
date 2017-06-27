<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;

class ExternalUsersController extends BaseRestController
{
    public function index()
    {
        return parent::index();
    }

    public function show($id)
    {
        $resource = $this->resources->where('user_id', $id)->firstOrFail();
        return ApiResponse::responseOk('', $resource);
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
        $resource = $this->resources->where('user_id', $id)->firstOrFail();
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
        $resource = $this->resources->where('user_id', $id)->firstOrFail();
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
