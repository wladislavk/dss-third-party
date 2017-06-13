<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Requests\LetterStore;
use DentalSleepSolutions\Http\Requests\LetterUpdate;
use DentalSleepSolutions\Http\Requests\LetterDestroy;
use DentalSleepSolutions\Contracts\Resources\Letter;
use DentalSleepSolutions\Contracts\Repositories\Letters;
use DentalSleepSolutions\Contracts\Resources\User;
use DentalSleepSolutions\Contracts\Resources\ContactType;
use Illuminate\Http\Request;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class LettersController extends Controller
{
    const DSS_USER_TYPE_FRANCHISEE = 1;
    const DSS_USER_TYPE_SOFTWARE = 2;

    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Letters $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Letters $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Letter $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Letter $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Letters $resources
     * @param  \DentalSleepSolutions\Http\Requests\LetterStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Letters $resources, LetterStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Letter $resource
     * @param  \DentalSleepSolutions\Http\Requests\LetterUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Letter $resource, LetterUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Letter $resource
     * @param  \DentalSleepSolutions\Http\Requests\LetterDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Letter $resource, LetterDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    public function getPending(Letters $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getPending($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getUnmailed(Letters $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getUnmailed($docId);

        return ApiResponse::responseOk('', $data);
    }

    // gets letters that were delivered for contact
    public function getContactSentLetters(Letters $resources, Request $request)
    {
        $contactId = $request->input('contact_id') ?: 0;
        $data = $resources->getContactSentLetters($contactId);

        return ApiResponse::responseOk('', $data);
    }

    // gets letters that were not delivered for contact
    public function getContactPendingLetters(Letters $resources, Request $request)
    {
        $contactId = $request->input('contact_id') ?: 0;
        $data = $resources->getContactPendingLetters($contactId);

        return ApiResponse::responseOk('', $data);
    }

    public function createWelcomeLetter(
        User $userResource,
        Letter $resource,
        ContactType $contactTypeResource,
        Request $request
    ) {
        $docId = $this->currentUser->docid ?: 0;

        $letterInfo = $userResource->getLetterInfo($docId);

        $templateId = $request->input('template_id') ?: 0;
        $contactTypeId = $request->input('contact_type_id') ?: 0;

        if ($letterInfo && $letterInfo->use_letters && $letterInfo->intro_letters) {
            $contactType = $contactTypeResource->find($contactTypeId);

            if ($contactType && $contactType->physician == 1) {
                if ($this->currentUser->user_type != self::DSS_USER_TYPE_SOFTWARE) {
                    $resource->createWelcomeLetter(1, $templateId, $docId);
                }
                $resource->createWelcomeLetter(2, $templateId, $docId);

                $data = [
                    'message' => 'This created an introduction letter. If you do not wish to send an introduction delete the letter from your Pending Letters queue.'
                ];
            }
        } else {
            $data = [];
        }
      
        return ApiResponse::responseOk('', $data);
    }

    public function getGeneratedDateOfIntroLetter(Letter $resource, Request $request)
    {
        $patientId = $request->input('patient_id') ?: 0;

        $data = $resource->getGeneratedDateOfIntroLetter($patientId);

        return ApiResponse::responseOk('', $data);
    }
}
