<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Resources\ReferredByContact;
use Illuminate\Http\Request;

class ReferredByContactsController extends Controller
{
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

    public function editingContact(
        ReferredByContact $referredByContactResource,
        Request $request,
        $contactId = null
    ) {
        $docId = $this->currentUser->docid ?: 0;

        $contactFormData = $request->input('contact_form_data', []);

        if ($contactId) {
            $validator = $this->getValidationFactory()->make(
                $contactFormData, (new \DentalSleepSolutions\Http\Requests\ReferredByContact())->updateRules()
            );
        } else {
            $validator = $this->getValidationFactory()->make(
                $contactFormData, (new \DentalSleepSolutions\Http\Requests\ReferredByContact())->storeRules()
            );
        }

        if ($validator->fails()) {
            return ApiResponse::responseError('', 422, $validator->messages());
        }
        if (count($contactFormData) == 0) {
            return ApiResponse::responseError('Contact data is empty.', 422);
        }

        // add1 + city + state + zip = not empty fields
        // we have checked them during the validation above, so referredby_info -> 1
        $contactFormData = array_merge($contactFormData, [
            'referredby_info' => 1,
            'docid'           => $docId,
            'ip_address'      => $request->ip()
        ]);

        $responseData = [];
        if ($contactId) {
            $referredByContactResource->updateContact($contactId, $contactFormData);

            $responseData['status'] = 'Edited Successfully';
        } else { // contactId = 0 -> creating a new contact
            $referredByContactResource->create($contactFormData);

            $responseData['status'] = 'Added Successfully';
        }

        return ApiResponse::responseOk('', $responseData);
    }
}
