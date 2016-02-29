<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\NoteStore;
use DentalSleepSolutions\Http\Requests\NoteUpdate;
use DentalSleepSolutions\Http\Requests\NoteDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Note;
use DentalSleepSolutions\Contracts\Repositories\Notes;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Notes $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Notes $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Note $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Note $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Notes $resources
     * @param  \DentalSleepSolutions\Http\Requests\NoteStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Notes $resources, NoteStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Note $resource
     * @param  \DentalSleepSolutions\Http\Requests\NoteUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Note $resource, NoteUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Note $resource
     * @param  \DentalSleepSolutions\Http\Requests\NoteDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Note $resource, NoteDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
