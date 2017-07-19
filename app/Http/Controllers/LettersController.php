<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\ContactType;
use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\Request;

class LettersController extends BaseRestController
{
    const DSS_USER_TYPE_FRANCHISEE = 1;
    const DSS_USER_TYPE_SOFTWARE = 2;

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
        $this->hasIp = false;
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

    public function getPending(Letter $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getPending($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getUnmailed(Letter $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getUnmailed($docId);

        return ApiResponse::responseOk('', $data);
    }

    // gets letters that were delivered for contact
    public function getContactSentLetters(Letter $resources, Request $request)
    {
        $contactId = $request->input('contact_id', 0);
        $data = $resources->getContactSentLetters($contactId);

        return ApiResponse::responseOk('', $data);
    }

    // gets letters that were not delivered for contact
    public function getContactPendingLetters(Letter $resources, Request $request)
    {
        $contactId = $request->input('contact_id', 0);
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

        $templateId = $request->input('template_id', 0);
        $contactTypeId = $request->input('contact_type_id', 0);

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
        $patientId = $request->input('patient_id', 0);

        $data = $resource->getGeneratedDateOfIntroLetter($patientId);

        return ApiResponse::responseOk('', $data);
    }
}
