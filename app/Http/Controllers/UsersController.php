<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\UserStore;
use DentalSleepSolutions\Http\Requests\UserUpdate;
use DentalSleepSolutions\Http\Requests\UserDestroy;
use DentalSleepSolutions\Http\Requests\UserCheck;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\User;
use DentalSleepSolutions\Contracts\Repositories\Users;
use DentalSleepSolutions\Libraries\Password;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Users $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Users $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\User $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Users $resources
     * @param  \DentalSleepSolutions\Http\Requests\UserStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Users $resources, UserStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\User $resource
     * @param  \DentalSleepSolutions\Http\Requests\UserUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(User $resource, UserUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\User $resource
     * @param  \DentalSleepSolutions\Http\Requests\UserDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $resource, UserDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    /**
     * Check username and password and get user data
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\User $resource
     * @param  \DentalSleepSolutions\Http\Requests\UserCheck $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(User $resource, UserCheck $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $salt = $resource->getSalt($username)->salt;

        if (!empty($salt)) {
            $password = Password::genPassword($password, $salt);

            $data = $resource->check($username, $password);
        } else {
            $data = [];
        }

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Get user type by user id
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\User $resource
     * @param  \DentalSleepSolutions\Http\Requests\UserCheck $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserType($userId, User $resource)
    {
        $data = $resource->getUserType($userId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Get info about current logined user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrentUserInfo(User $resource)
    {
        return ApiResponse::responseOk('', $this->currentUser);
    }

    /**
     * Get course staff of current logined user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCourseStaff(User $resource)
    {
        $userId = $this->currentUser->id ?: 0;

        $data = $resource->getCourseStaff($userId);

        return ApiResponse::responseOk('', $data);
    }

    public function getPaymentReports(Users $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getPaymentReports($docId);

        return ApiResponse::responseOk('', $data);
    }
}
