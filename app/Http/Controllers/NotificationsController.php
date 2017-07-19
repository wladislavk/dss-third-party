<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\ApiResponse;

class NotificationsController extends BaseRestController
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

    /**
     * Get notifications by filter.
     *
     * @param Patient $resources
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithFilter(Patient $resources, Request $request)
    {
        $fields = $request->input('fields', []);
        $where  = $request->input('where', []);

        $patients = $resources->getWithFilter($fields, $where);

        return ApiResponse::responseOk('', $patients);
    }
}
