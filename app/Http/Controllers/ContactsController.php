<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ContactStore;
use DentalSleepSolutions\Http\Requests\ContactUpdate;
use DentalSleepSolutions\Http\Requests\ContactDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Contact;
use DentalSleepSolutions\Contracts\Repositories\Contacts;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Contacts $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Contacts $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Contact $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Contact $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Contacts $resources
     * @param  \DentalSleepSolutions\Http\Requests\ContactStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Contacts $resources, ContactStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Contact $resource
     * @param  \DentalSleepSolutions\Http\Requests\ContactUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Contact $resource, ContactUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Contact $resource
     * @param  \DentalSleepSolutions\Http\Requests\ContactDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Contact $resource, ContactDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    public function find(Contacts $resources, Request $request)
    {
        $docId = $this->currentUser->docid ?: 0;

        $contactType     = $request->input('contacttype') ?: 0;
        $status          = $request->input('status') ?: 0;
        $letter          = $request->input('letter') ?: '';
        $sortBy          = $request->input('sort_column') ?: '';
        $sortDir         = $request->input('sort_direction') ?: '';
        $page            = $request->input('page') ?: 0;
        $contactsPerPage = $request->input('contacts_per_page') ?: 0;

        $data = $resources->find(
            $contactType,
            $status,
            $docId,
            $letter,
            $sortBy,
            $sortDir,
            $page,
            $contactsPerPage
        );

        return ApiResponse::responseOk('', $data);
    }
}
