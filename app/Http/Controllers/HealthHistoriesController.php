<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\HealthHistories;
use Illuminate\Http\Request;

class HealthHistoriesController extends Controller
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
     * @param  \DentalSleepSolutions\Contracts\Repositories\HealthHistories $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithFilter(HealthHistories $resources, Request $request)
    {
        $fields = $request->input('fields', []);
        $where  = $request->input('where', []);

        $healthHistories = $resources->getWithFilter($fields, $where);

        return ApiResponse::responseOk('', $healthHistories);
    }
}
