<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;

class LoginDetailsController extends BaseRestController
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
        $loginId = 0;
        $userId = 0;
        if ($this->currentUser) {
            $loginId = intval($this->currentUser->loginid);
            $userId = intval($this->currentUser->id);
        }

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
