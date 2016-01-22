<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\AdminStore;
use DentalSleepSolutions\Http\Requests\AdminUpdate;
use DentalSleepSolutions\Http\Requests\AdminDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Admin;
use DentalSleepSolutions\Contracts\Repositories\Admins;
use Carbon\Carbon;

use DentalSleepSolutions\Libraries\Password;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Admins $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Admins $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Admin $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Admin $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Admins $resources
     * @param  \DentalSleepSolutions\Http\Requests\AdminStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Admins $resources, AdminStore $request)
    {
        $salt       = Password::createSalt();
        $password   = Password::genPassword($request->input('password'), $salt);

        $data = array_merge($request->all(), [
            'salt'               => $salt,
            'password'           => $password,
            'last_accessed_date' => Carbon::now(),
            'ip_address'         => $request->ip()
        ]);

        $resource = $resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Admin $resource
     * @param  \DentalSleepSolutions\Http\Requests\AdminUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Admin $resource, AdminUpdate $request)
    {
        $data = array_merge($request->all(), [
            'last_accessed_date' => Carbon::now(),
        ]);

        if ($request->has('password')) {
            $salt       = Password::createSalt();
            $password   = Password::genPassword($request->input('password'), $salt);

            $data = array_merge($data, [
                'salt'     => $salt,
                'password' => $password,
            ]);
        }

        $resource->update($data);

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Admin $resource
     * @param  \DentalSleepSolutions\Http\Requests\AdminDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Admin $resource, AdminDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
