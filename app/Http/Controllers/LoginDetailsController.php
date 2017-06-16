<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;

class LoginDetailsController extends Controller
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
        $loginId = $this->currentUser->loginid ?: 0;
        $userId = $this->currentUser->id ?: 0;

        $data = array_merge($this->request->all(), [
            'loginid'    => $loginId,
            'userid'     => $userId,
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
}
