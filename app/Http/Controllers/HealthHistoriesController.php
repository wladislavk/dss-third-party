<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\HealthHistory;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\Request;

class HealthHistoriesController extends BaseRestController
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
     * Get health histories by filter.
     *
     * @param HealthHistory $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithFilter(HealthHistory $resources, Request $request)
    {
        $fields = $request->input('fields', []);
        $where  = $request->input('where', []);

        $healthHistories = $resources->getWithFilter($fields, $where);

        return ApiResponse::responseOk('', $healthHistories);
    }
}
