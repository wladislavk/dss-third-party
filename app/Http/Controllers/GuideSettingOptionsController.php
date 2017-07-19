<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\GuideSettingOption;
use DentalSleepSolutions\StaticClasses\ApiResponse;

class GuideSettingOptionsController extends BaseRestController
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

    public function getOptionsForSettingIds(GuideSettingOption $resources)
    {
        $guideSettingOptions = $resources->getOptionsBySettingIds();

        return ApiResponse::responseOk('', $guideSettingOptions);
    }
}
