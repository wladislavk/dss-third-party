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

    /**
     * @SWG\Get(
     *     path="/letters",
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
     *                         @SWG\Items(ref="#/definitions/Letter")
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
     *     path="/letters/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Letter")
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
     *     path="/letters",
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="stepid", in="formData", type="integer"),
     *     @SWG\Parameter(name="delivery_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="send_method", in="formData", type="string"),
     *     @SWG\Parameter(name="template", in="formData", type="string"),
     *     @SWG\Parameter(name="pdf_path", in="formData", type="string"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="delivered", in="formData", type="integer"),
     *     @SWG\Parameter(name="deleted", in="formData", type="boolean"),
     *     @SWG\Parameter(name="templateid", in="formData", type="integer"),
     *     @SWG\Parameter(name="parentid", in="formData", type="integer"),
     *     @SWG\Parameter(name="topatient", in="formData", type="boolean"),
     *     @SWG\Parameter(name="md_list", in="formData", type="string"),
     *     @SWG\Parameter(name="md_referral_list", in="formData", type="string"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="date_sent", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="info_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="edit_userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="mailed_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="mailed_once", in="formData", type="integer"),
     *     @SWG\Parameter(name="template_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="cc_topatient", in="formData", type="integer"),
     *     @SWG\Parameter(name="cc_md_list", in="formData", type="string"),
     *     @SWG\Parameter(name="cc_md_referral_list", in="formData", type="string"),
     *     @SWG\Parameter(name="font_family", in="formData", type="string"),
     *     @SWG\Parameter(name="font_size", in="formData", type="integer"),
     *     @SWG\Parameter(name="pat_referral_list", in="formData", type="string"),
     *     @SWG\Parameter(name="cc_pat_referral_list", in="formData", type="string"),
     *     @SWG\Parameter(name="deleted_by", in="formData", type="integer"),
     *     @SWG\Parameter(name="deleted_on", in="formData", type="string", format="dateTime"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Letter")
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
     *     path="/letters/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="stepid", in="formData", type="integer"),
     *     @SWG\Parameter(name="delivery_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="send_method", in="formData", type="string"),
     *     @SWG\Parameter(name="template", in="formData", type="string"),
     *     @SWG\Parameter(name="pdf_path", in="formData", type="string"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="delivered", in="formData", type="integer"),
     *     @SWG\Parameter(name="deleted", in="formData", type="boolean"),
     *     @SWG\Parameter(name="templateid", in="formData", type="integer"),
     *     @SWG\Parameter(name="parentid", in="formData", type="integer"),
     *     @SWG\Parameter(name="topatient", in="formData", type="boolean"),
     *     @SWG\Parameter(name="md_list", in="formData", type="string"),
     *     @SWG\Parameter(name="md_referral_list", in="formData", type="string"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="date_sent", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="info_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="edit_userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="mailed_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="mailed_once", in="formData", type="integer"),
     *     @SWG\Parameter(name="template_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="cc_topatient", in="formData", type="integer"),
     *     @SWG\Parameter(name="cc_md_list", in="formData", type="string"),
     *     @SWG\Parameter(name="cc_md_referral_list", in="formData", type="string"),
     *     @SWG\Parameter(name="font_family", in="formData", type="string"),
     *     @SWG\Parameter(name="font_size", in="formData", type="integer"),
     *     @SWG\Parameter(name="pat_referral_list", in="formData", type="string"),
     *     @SWG\Parameter(name="cc_pat_referral_list", in="formData", type="string"),
     *     @SWG\Parameter(name="deleted_by", in="formData", type="integer"),
     *     @SWG\Parameter(name="deleted_on", in="formData", type="string", format="dateTime"),
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
     *     path="/letters/{id}",
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
     *     path="/letters/pending",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Letter $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPending(Letter $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getPending($docId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/letters/unmailed",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Letter $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnmailed(Letter $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getUnmailed($docId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/letters/delivered-for-contact",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * gets letters that were delivered for contact
     *
     * @param Letter $resources
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContactSentLetters(Letter $resources, Request $request)
    {
        $contactId = $request->input('contact_id', 0);
        $data = $resources->getContactSentLetters($contactId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/letters/not-delivered-for-contact",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * gets letters that were not delivered for contact
     *
     * @param Letter $resources
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContactPendingLetters(Letter $resources, Request $request)
    {
        $contactId = $request->input('contact_id', 0);
        $data = $resources->getContactPendingLetters($contactId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/letters/create-welcome-letter",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param User $userResource
     * @param Letter $resource
     * @param ContactType $contactTypeResource
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @SWG\Post(
     *     path="/letters/gen-date-of-intro",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Letter $resource
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGeneratedDateOfIntroLetter(Letter $resource, Request $request)
    {
        $patientId = $request->input('patient_id', 0);

        $data = $resource->getGeneratedDateOfIntroLetter($patientId);

        return ApiResponse::responseOk('', $data);
    }
}
