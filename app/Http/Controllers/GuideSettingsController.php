<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\GuideSettings;
use Illuminate\Http\Request;

class GuideSettingsController extends BaseRestController
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

    public function getAllOrderBy(GuideSettings $resources, Request $request)
    {
        $order = $request->input('order', 'name');

        $guideSettings = $resources->getAllOrderBy($order);

        return ApiResponse::responseOk('', $guideSettings);
    }
}
