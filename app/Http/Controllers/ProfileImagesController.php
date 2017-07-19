<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\ProfileImage;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\Request;

class ProfileImagesController extends BaseRestController
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

    public function getProfilePhoto(ProfileImage $resource, Request $request)
    {
        $patientId = $request->input('patient_id', 0);

        $data = $resource->getProfilePhoto($patientId);

        return ApiResponse::responseOk('', $data);
    }

    public function getInsuranceCardImage(ProfileImage $resource, Request $request)
    {
        $patientId = $request->input('patient_id', 0);

        $data = $resource->getInsuranceCardImage($patientId);

        return ApiResponse::responseOk('', $data);
    }
}
