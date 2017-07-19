<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use DentalSleepSolutions\StaticClasses\ApiResponse;
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

    public function getAllOrderBy(GuideSetting $resources, Request $request)
    {
        $order = $request->input('order', 'name');

        $guideSettings = $resources->getAllOrderBy($order);

        return ApiResponse::responseOk('', $guideSettings);
    }
}
