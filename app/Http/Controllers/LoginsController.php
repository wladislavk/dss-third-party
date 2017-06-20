<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;

class LoginsController extends BaseRestController
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

    /**
     * Log out the user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // TODO: Need to implement setting the logout_date field in dental_login

        $this->auth->invalidate($this->auth->getToken());

        return ApiResponse::responseOk('User was logged out');
    }
}
