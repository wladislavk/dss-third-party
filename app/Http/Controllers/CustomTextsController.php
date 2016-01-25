<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\CustomTextStore;
use DentalSleepSolutions\Http\Requests\CustomTextUpdate;
use DentalSleepSolutions\Http\Requests\CustomTextDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\CustomText;
use DentalSleepSolutions\Contracts\Repositories\CustomTexts;
use Carbon\Carbon;

class CustomTextsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\CustomTexts $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CustomTexts $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\CustomText $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(CustomText $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\CustomTexts $resources
     * @param  \DentalSleepSolutions\Http\Requests\CustomTextStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CustomTexts $resources, CustomTextStore $request)
    {
        $data = array_merge($request->all(), [
            'ip_address' => $request->ip()
        ]);

        $resource = $resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\CustomText $resource
     * @param  \DentalSleepSolutions\Http\Requests\CustomTextUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CustomText $resource, CustomTextUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\CustomText $resource
     * @param  \DentalSleepSolutions\Http\Requests\CustomTextDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CustomText $resource, CustomTextDestroy $request) {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
