<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\AllergenStore;
use DentalSleepSolutions\Http\Requests\AllergenUpdate;
use DentalSleepSolutions\Http\Requests\AllergenDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Allergen;
use DentalSleepSolutions\Contracts\Repositories\Allergens;
use Carbon\Carbon;

class AllergensController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Allergens $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Allergens $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Allergen $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Allergen $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Allergens $resources
     * @param  \DentalSleepSolutions\Http\Requests\AllergenStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Allergens $resources, AllergenStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Allergen $resource
     * @param  \DentalSleepSolutions\Http\Requests\AllergenUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Allergen $resource, AllergenUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Allergen $resource
     * @param  \DentalSleepSolutions\Http\Requests\AllergenDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Allergen $resource, AllergenDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
