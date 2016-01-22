<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\CalendarStore;
use DentalSleepSolutions\Http\Requests\CalendarUpdate;
use DentalSleepSolutions\Http\Requests\CalendarDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Calendar;
use DentalSleepSolutions\Contracts\Repositories\Calendars;
use Carbon\Carbon;

class CalendarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Calendars $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Calendars $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Calendar $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Calendar $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Calendars $resources
     * @param  \DentalSleepSolutions\Http\Requests\CalendarStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Calendars $resources, CalendarStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Calendar $resource
     * @param  \DentalSleepSolutions\Http\Requests\CalendarUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Calendar $resource, CalendarUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Calendar $resource
     * @param  \DentalSleepSolutions\Http\Requests\CalendarDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Calendar $resource, CalendarDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
