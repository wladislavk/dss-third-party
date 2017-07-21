<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\ReferredByContact;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ReferredByContactRepository;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\Request;

class ReferredByContactsController extends BaseRestController
{
    /** @var ReferredByContactRepository */
    protected $repository;

    /**
     * @SWG\Get(
     *     path="/referred-by-contacts",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/ReferredByContact")
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function index()
    {
        return parent::index();
    }

    /**
     * @SWG\Get(
     *     path="/referred-by-contacts/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/ReferredByContact")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function show($id)
    {
        return parent::show($id);
    }

    /**
     * @SWG\Post(
     *     path="/referred-by-contacts",
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="salutation", in="formData", type="string"),
     *     @SWG\Parameter(name="lastname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="firstname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="middlename", in="formData", type="string"),
     *     @SWG\Parameter(name="company", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="add1", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="add2", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="state", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="zip", in="formData", type="string", required=true, pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="phone1", in="formData", type="string", required=true, pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="phone2", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="fax", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email", required=true),
     *     @SWG\Parameter(name="national_provider_id", in="formData", type="string"),
     *     @SWG\Parameter(name="qualifier", in="formData", type="integer"),
     *     @SWG\Parameter(name="qualifierid", in="formData", type="string"),
     *     @SWG\Parameter(name="greeting", in="formData", type="string"),
     *     @SWG\Parameter(name="sincerely", in="formData", type="string"),
     *     @SWG\Parameter(name="notes", in="formData", type="string"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="preferredcontact", in="formData", type="string"),
     *     @SWG\Parameter(name="referredby_info", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/ReferredByContact")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function store()
    {
        $this->hasIp = false;
        return parent::store();
    }

    /**
     * @SWG\Put(
     *     path="/referred-by-contacts/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="salutation", in="formData", type="string"),
     *     @SWG\Parameter(name="lastname", in="formData", type="string"),
     *     @SWG\Parameter(name="firstname", in="formData", type="string"),
     *     @SWG\Parameter(name="middlename", in="formData", type="string"),
     *     @SWG\Parameter(name="company", in="formData", type="string"),
     *     @SWG\Parameter(name="add1", in="formData", type="string"),
     *     @SWG\Parameter(name="add2", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string"),
     *     @SWG\Parameter(name="state", in="formData", type="string"),
     *     @SWG\Parameter(name="zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="phone1", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="phone2", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="fax", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email"),
     *     @SWG\Parameter(name="national_provider_id", in="formData", type="string"),
     *     @SWG\Parameter(name="qualifier", in="formData", type="integer"),
     *     @SWG\Parameter(name="qualifierid", in="formData", type="string"),
     *     @SWG\Parameter(name="greeting", in="formData", type="string"),
     *     @SWG\Parameter(name="sincerely", in="formData", type="string"),
     *     @SWG\Parameter(name="notes", in="formData", type="string"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="preferredcontact", in="formData", type="string"),
     *     @SWG\Parameter(name="referredby_info", in="formData", type="integer"),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function update($id)
    {
        return parent::update($id);
    }

    /**
     * @SWG\Delete(
     *     path="/referred-by-contacts/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="Resource deleted", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function destroy($id)
    {
        return parent::destroy($id);
    }

    /**
     * @SWG\Post(
     *     path="/referred-by-contacts/edit/{contactId}",
     *     @SWG\Parameter(name="contactId", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @SWG\Post(
     *     path="/referred-by-contacts/edit",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @param int|null $contactId
     * @return \Illuminate\Http\JsonResponse
     */
    public function editingContact(
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
            $this->repository->updateContact($contactId, $contactFormData);

            $responseData['status'] = 'Edited Successfully';
        } else { // contactId = 0 -> creating a new contact
            $this->repository->create($contactFormData);

            $responseData['status'] = 'Added Successfully';
        }

        return ApiResponse::responseOk('', $responseData);
    }
}
