<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ReferredByContactStore;
use DentalSleepSolutions\Http\Requests\ReferredByContactUpdate;
use DentalSleepSolutions\Http\Requests\ReferredByContactDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\ReferredByContact;
use DentalSleepSolutions\Contracts\Repositories\ReferredByContacts;
use Illuminate\Http\Request;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class ReferredByContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ReferredByContacts $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ReferredByContacts $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ReferredByContact $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ReferredByContact $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ReferredByContacts $resources
     * @param  \DentalSleepSolutions\Http\Requests\ReferredByContactStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ReferredByContacts $resources, ReferredByContactStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ReferredByContact $resource
     * @param  \DentalSleepSolutions\Http\Requests\ReferredByContactUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ReferredByContact $resource, ReferredByContactUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ReferredByContact $resource
     * @param  \DentalSleepSolutions\Http\Requests\ReferredByContactDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ReferredByContact $resource, ReferredByContactDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    public function editingContact(Request $request, $contactId = null)
    {
        $contactFormData = $request->input('contact_form_data') ?: [];

        if ($contactId) {
            $validator = $this->getValidationFactory()->make(
                $contactFormData, (new ReferredByContactUpdate())->rules()
            );
        } else {
            $validator = $this->getValidationFactory()->make(
                $contactFormData, (new ReferredByContactStore())->rules()
            );
        }

        if ($validator->fails()) {
            return ApiResponse::responseError('', 422, $validator->messages());
        } elseif (count($contactFormData) == 0) {
            return ApiResponse::responseError('Contact data is empty.', 422);
        }

        $responseData = [];
        if ($contactId) {
            $responseData['status'] = 'Edited Successfully';
        } else { // contactId = 0 -> creating a new contact
            $responseData['status'] = '';
        }

        return ApiResponse::responseOk('', $responseData);
    }
}
