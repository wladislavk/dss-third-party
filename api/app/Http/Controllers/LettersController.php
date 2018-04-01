<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Helpers\LetterModelTransformer;
use DentalSleepSolutions\Helpers\WelcomeLetterCreator;
use DentalSleepSolutions\Facades\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class LettersController extends BaseRestController
{
    const DSS_USER_TYPE_FRANCHISEE = 1;
    const DSS_USER_TYPE_SOFTWARE = 2;

    /** @var LetterRepository */
    protected $repository;

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
     *
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        return parent::destroy($id);
    }

    /**
     * @SWG\Post(
     *     path="/letters/delivered-for-contact",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * gets letters that were delivered for contact
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContactSentLetters(Request $request)
    {
        $contactId = $request->input('contact_id', 0);
        $data = $this->repository->getContactSentLetters($contactId);

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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContactPendingLetters(Request $request)
    {
        $contactId = $request->input('contact_id', 0);
        $data = $this->repository->getContactPendingLetters($contactId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/letters/create-welcome-letter",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param WelcomeLetterCreator $welcomeLetterCreator
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createWelcomeLetter(
        WelcomeLetterCreator $welcomeLetterCreator,
        Request $request
    ) {
        $templateId = (int)$request->input('template_id', 0);
        $contactTypeId = (int)$request->input('contact_type_id', 0);

        try {
            $data = $welcomeLetterCreator->createWelcomeLetter(
                $this->user->docid, $templateId, $contactTypeId, $this->user->user_type
            );
        } catch (ValidatorException $e) {
            return ApiResponse::responseError($e->getMessage());
        }

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/letters/gen-date-of-intro",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGeneratedDateOfIntroLetter(Request $request)
    {
        $patientId = $request->input('patient_id', 0);

        $data = $this->repository->getGeneratedDateOfIntroLetter($patientId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Get(
     *     path="/letters/by-patient-and-info",
     *     @SWG\Parameter(name="patient_id", in="query", type="integer", required=true),
     *     @SWG\Parameter(name="info_ids", in="query", type="string", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param LetterModelTransformer $letterModelTransformer
     * @param Request $request
     * @return JsonResponse
     */
    public function getByPatientAndInfo(LetterModelTransformer $letterModelTransformer, Request $request): JsonResponse
    {
        $patientId = (int)$request->input('patient_id');
        $infoIds = $request->input('info_ids', []);
        array_walk($infoIds, function ($element) {
            return (int)$element;
        });
        $data = $this->repository->getByPatientAndInfo($patientId, $infoIds);
        $data = $letterModelTransformer->transformLetters($data);
        return ApiResponse::responseOk('', $data);
    }
}
