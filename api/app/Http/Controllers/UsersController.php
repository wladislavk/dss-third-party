<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Services\Users\CurrentUserInfoRetriever;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Prettus\Repository\Exceptions\RepositoryException;

class UsersController extends BaseRestController
{
    const DSS_USER_STATUS_ACTIVE    = 1;
    const DSS_USER_STATUS_INACTIVE  = 2;
    const DSS_USER_STATUS_SUSPENDED = 3;

    const STATUS_LABELS = [
        self::DSS_USER_STATUS_ACTIVE    => 'Active',
        self::DSS_USER_STATUS_INACTIVE  => 'In-Active',
        self::DSS_USER_STATUS_SUSPENDED => 'Suspended',
    ];

    /** @var UserRepository */
    protected $repository;

    /**
     * @SWG\Get(
     *     path="/users",
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
     *                         @SWG\Items(ref="#/definitions/User")
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
     *     path="/users/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/User")
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
     *     path="/users",
     *     @SWG\Parameter(name="user_access", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="username", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="npi", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="password", in="formData", type="string"),
     *     @SWG\Parameter(name="name", in="formData", type="string"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email", required=true),
     *     @SWG\Parameter(name="address", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string"),
     *     @SWG\Parameter(name="state", in="formData", type="string"),
     *     @SWG\Parameter(name="zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="medicare_npi", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="tax_id_or_ssn", in="formData", type="string"),
     *     @SWG\Parameter(name="producer", in="formData", type="integer"),
     *     @SWG\Parameter(name="practice", in="formData", type="string"),
     *     @SWG\Parameter(name="email_header", in="formData", type="string", pattern="^dss_email_header_[0-9]{6}_[0-9]{4}\.(gif|png|bmp|jpg|jpeg)$"),
     *     @SWG\Parameter(name="email_footer", in="formData", type="string", pattern="^dss_email_footer_[0-9]{6}_[0-9]{4}\.(gif|png|bmp|jpg|jpeg)$"),
     *     @SWG\Parameter(name="fax_header", in="formData", type="string", pattern="^dss_print_header_[0-9]{6}_[0-9]{4}\.(gif|png|bmp|jpg|jpeg)$"),
     *     @SWG\Parameter(name="fax_footer", in="formData", type="string", pattern="^dss_print_footer_[0-9]{6}_[0-9]{4}\.(gif|png|bmp|jpg|jpeg)$"),
     *     @SWG\Parameter(name="salt", in="formData", type="string"),
     *     @SWG\Parameter(name="recover_hash", in="formData", type="string"),
     *     @SWG\Parameter(name="recover_time", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ssn", in="formData", type="boolean"),
     *     @SWG\Parameter(name="ein", in="formData", type="boolean"),
     *     @SWG\Parameter(name="use_patient_portal", in="formData", type="boolean"),
     *     @SWG\Parameter(name="mailing_practice", in="formData", type="string"),
     *     @SWG\Parameter(name="mailing_name", in="formData", type="string"),
     *     @SWG\Parameter(name="mailing_address", in="formData", type="string"),
     *     @SWG\Parameter(name="mailing_city", in="formData", type="string"),
     *     @SWG\Parameter(name="mailing_state", in="formData", type="string"),
     *     @SWG\Parameter(name="mailing_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="mailing_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="last_accessed_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="use_digital_fax", in="formData", type="boolean"),
     *     @SWG\Parameter(name="fax", in="formData", type="string"),
     *     @SWG\Parameter(name="use_letters", in="formData", type="boolean"),
     *     @SWG\Parameter(name="sign_notes", in="formData", type="integer"),
     *     @SWG\Parameter(name="use_eligible_api", in="formData", type="boolean"),
     *     @SWG\Parameter(name="access_code", in="formData", type="string"),
     *     @SWG\Parameter(name="text_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="text_num", in="formData", type="integer"),
     *     @SWG\Parameter(name="access_code_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="registration_email_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="producer_files", in="formData", type="boolean"),
     *     @SWG\Parameter(name="medicare_ptan", in="formData", type="string"),
     *     @SWG\Parameter(name="use_course", in="formData", type="boolean"),
     *     @SWG\Parameter(name="use_course_staff", in="formData", type="boolean"),
     *     @SWG\Parameter(name="manage_staff", in="formData", type="boolean"),
     *     @SWG\Parameter(name="cc_id", in="formData", type="string", pattern="^cus_[A-Za-z0-9_]+$"),
     *     @SWG\Parameter(name="user_type", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="letter_margin_header", in="formData", type="integer"),
     *     @SWG\Parameter(name="letter_margin_footer", in="formData", type="integer"),
     *     @SWG\Parameter(name="letter_margin_top", in="formData", type="integer"),
     *     @SWG\Parameter(name="letter_margin_bottom", in="formData", type="integer"),
     *     @SWG\Parameter(name="letter_margin_left", in="formData", type="integer"),
     *     @SWG\Parameter(name="letter_margin_right", in="formData", type="integer"),
     *     @SWG\Parameter(name="claim_margin_top", in="formData", type="integer"),
     *     @SWG\Parameter(name="claim_margin_left", in="formData", type="integer"),
     *     @SWG\Parameter(name="logo", in="formData", type="string", pattern="^user_logo_[0-9]+\.(gif|png|bmp|jpg|jpeg)$"),
     *     @SWG\Parameter(name="homepage", in="formData", type="boolean"),
     *     @SWG\Parameter(name="use_letter_header", in="formData", type="boolean"),
     *     @SWG\Parameter(name="access_code_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="first_name", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="last_name", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="indent_address", in="formData", type="boolean"),
     *     @SWG\Parameter(name="registration_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="header_space", in="formData", type="integer"),
     *     @SWG\Parameter(name="billing_company_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="edx_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="help_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="tracker_letters", in="formData", type="integer"),
     *     @SWG\Parameter(name="intro_letters", in="formData", type="integer"),
     *     @SWG\Parameter(name="plan_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="suspended_reason", in="formData", type="string"),
     *     @SWG\Parameter(name="suspended_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="signature_file", in="formData", type="string"),
     *     @SWG\Parameter(name="signature_json", in="formData", type="string"),
     *     @SWG\Parameter(name="use_service_npi", in="formData", type="integer"),
     *     @SWG\Parameter(name="service_name", in="formData", type="string"),
     *     @SWG\Parameter(name="service_address", in="formData", type="string"),
     *     @SWG\Parameter(name="service_city", in="formData", type="string"),
     *     @SWG\Parameter(name="service_state", in="formData", type="string"),
     *     @SWG\Parameter(name="service_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="service_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="service_fax", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="service_npi", in="formData", type="string"),
     *     @SWG\Parameter(name="service_medicare_npi", in="formData", type="string"),
     *     @SWG\Parameter(name="service_medicare_ptan", in="formData", type="string"),
     *     @SWG\Parameter(name="service_tax_id_or_ssn", in="formData", type="string"),
     *     @SWG\Parameter(name="service_ssn", in="formData", type="integer"),
     *     @SWG\Parameter(name="service_ein", in="formData", type="integer"),
     *     @SWG\Parameter(name="eligible_test", in="formData", type="integer"),
     *     @SWG\Parameter(name="billing_plan_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="post_ledger_adjustments", in="formData", type="integer"),
     *     @SWG\Parameter(name="edit_ledger_entries", in="formData", type="integer"),
     *     @SWG\Parameter(name="use_payment_reports", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/User")
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
        return parent::store();
    }

    /**
     * @SWG\Put(
     *     path="/users/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="user_access", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="username", in="formData", type="string"),
     *     @SWG\Parameter(name="npi", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="password", in="formData", type="string"),
     *     @SWG\Parameter(name="name", in="formData", type="string"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email"),
     *     @SWG\Parameter(name="address", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string"),
     *     @SWG\Parameter(name="state", in="formData", type="string"),
     *     @SWG\Parameter(name="zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="medicare_npi", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="tax_id_or_ssn", in="formData", type="string"),
     *     @SWG\Parameter(name="producer", in="formData", type="integer"),
     *     @SWG\Parameter(name="practice", in="formData", type="string"),
     *     @SWG\Parameter(name="email_header", in="formData", type="string", pattern="^dss_email_header_[0-9]{6}_[0-9]{4}\.(gif|png|bmp|jpg|jpeg)$"),
     *     @SWG\Parameter(name="email_footer", in="formData", type="string", pattern="^dss_email_footer_[0-9]{6}_[0-9]{4}\.(gif|png|bmp|jpg|jpeg)$"),
     *     @SWG\Parameter(name="fax_header", in="formData", type="string", pattern="^dss_print_header_[0-9]{6}_[0-9]{4}\.(gif|png|bmp|jpg|jpeg)$"),
     *     @SWG\Parameter(name="fax_footer", in="formData", type="string", pattern="^dss_print_footer_[0-9]{6}_[0-9]{4}\.(gif|png|bmp|jpg|jpeg)$"),
     *     @SWG\Parameter(name="salt", in="formData", type="string"),
     *     @SWG\Parameter(name="recover_hash", in="formData", type="string"),
     *     @SWG\Parameter(name="recover_time", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ssn", in="formData", type="boolean"),
     *     @SWG\Parameter(name="ein", in="formData", type="boolean"),
     *     @SWG\Parameter(name="use_patient_portal", in="formData", type="boolean"),
     *     @SWG\Parameter(name="mailing_practice", in="formData", type="string"),
     *     @SWG\Parameter(name="mailing_name", in="formData", type="string"),
     *     @SWG\Parameter(name="mailing_address", in="formData", type="string"),
     *     @SWG\Parameter(name="mailing_city", in="formData", type="string"),
     *     @SWG\Parameter(name="mailing_state", in="formData", type="string"),
     *     @SWG\Parameter(name="mailing_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="mailing_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="last_accessed_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="use_digital_fax", in="formData", type="boolean"),
     *     @SWG\Parameter(name="fax", in="formData", type="string"),
     *     @SWG\Parameter(name="use_letters", in="formData", type="boolean"),
     *     @SWG\Parameter(name="sign_notes", in="formData", type="integer"),
     *     @SWG\Parameter(name="use_eligible_api", in="formData", type="boolean"),
     *     @SWG\Parameter(name="access_code", in="formData", type="string"),
     *     @SWG\Parameter(name="text_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="text_num", in="formData", type="integer"),
     *     @SWG\Parameter(name="access_code_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="registration_email_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="producer_files", in="formData", type="boolean"),
     *     @SWG\Parameter(name="medicare_ptan", in="formData", type="string"),
     *     @SWG\Parameter(name="use_course", in="formData", type="boolean"),
     *     @SWG\Parameter(name="use_course_staff", in="formData", type="boolean"),
     *     @SWG\Parameter(name="manage_staff", in="formData", type="boolean"),
     *     @SWG\Parameter(name="cc_id", in="formData", type="string", pattern="^cus_[A-Za-z0-9_]+$"),
     *     @SWG\Parameter(name="user_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="letter_margin_header", in="formData", type="integer"),
     *     @SWG\Parameter(name="letter_margin_footer", in="formData", type="integer"),
     *     @SWG\Parameter(name="letter_margin_top", in="formData", type="integer"),
     *     @SWG\Parameter(name="letter_margin_bottom", in="formData", type="integer"),
     *     @SWG\Parameter(name="letter_margin_left", in="formData", type="integer"),
     *     @SWG\Parameter(name="letter_margin_right", in="formData", type="integer"),
     *     @SWG\Parameter(name="claim_margin_top", in="formData", type="integer"),
     *     @SWG\Parameter(name="claim_margin_left", in="formData", type="integer"),
     *     @SWG\Parameter(name="logo", in="formData", type="string", pattern="^user_logo_[0-9]+\.(gif|png|bmp|jpg|jpeg)$"),
     *     @SWG\Parameter(name="homepage", in="formData", type="boolean"),
     *     @SWG\Parameter(name="use_letter_header", in="formData", type="boolean"),
     *     @SWG\Parameter(name="access_code_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="first_name", in="formData", type="string"),
     *     @SWG\Parameter(name="last_name", in="formData", type="string"),
     *     @SWG\Parameter(name="indent_address", in="formData", type="boolean"),
     *     @SWG\Parameter(name="registration_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="header_space", in="formData", type="integer"),
     *     @SWG\Parameter(name="billing_company_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="edx_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="help_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="tracker_letters", in="formData", type="integer"),
     *     @SWG\Parameter(name="intro_letters", in="formData", type="integer"),
     *     @SWG\Parameter(name="plan_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="suspended_reason", in="formData", type="string"),
     *     @SWG\Parameter(name="suspended_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="signature_file", in="formData", type="string"),
     *     @SWG\Parameter(name="signature_json", in="formData", type="string"),
     *     @SWG\Parameter(name="use_service_npi", in="formData", type="integer"),
     *     @SWG\Parameter(name="service_name", in="formData", type="string"),
     *     @SWG\Parameter(name="service_address", in="formData", type="string"),
     *     @SWG\Parameter(name="service_city", in="formData", type="string"),
     *     @SWG\Parameter(name="service_state", in="formData", type="string"),
     *     @SWG\Parameter(name="service_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="service_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="service_fax", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="service_npi", in="formData", type="string"),
     *     @SWG\Parameter(name="service_medicare_npi", in="formData", type="string"),
     *     @SWG\Parameter(name="service_medicare_ptan", in="formData", type="string"),
     *     @SWG\Parameter(name="service_tax_id_or_ssn", in="formData", type="string"),
     *     @SWG\Parameter(name="service_ssn", in="formData", type="integer"),
     *     @SWG\Parameter(name="service_ein", in="formData", type="integer"),
     *     @SWG\Parameter(name="eligible_test", in="formData", type="integer"),
     *     @SWG\Parameter(name="billing_plan_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="post_ledger_adjustments", in="formData", type="integer"),
     *     @SWG\Parameter(name="edit_ledger_entries", in="formData", type="integer"),
     *     @SWG\Parameter(name="use_payment_reports", in="formData", type="integer"),
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
     *     path="/users/{id}",
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
     *     path="/users/check",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * Get the account status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check()
    {
        $accountStatuses = [
            self::DSS_USER_STATUS_ACTIVE,
            self::DSS_USER_STATUS_INACTIVE,
            self::DSS_USER_STATUS_SUSPENDED,
        ];

        $data = [
            'type' => '',
        ];

        if (in_array($this->user->status, $accountStatuses)) {
            $data['type'] = self::STATUS_LABELS[$this->user->status];
        }

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Get(
     *     path="/users/current",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * Get info about current logged in user
     *
     * @param CurrentUserInfoRetriever $currentUserInfoRetriever
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrentUserInfo(CurrentUserInfoRetriever $currentUserInfoRetriever)
    {
        try {
            $userData = $currentUserInfoRetriever->getCurrentUserInfo($this->user);
        } catch (RepositoryException $e) {
            return ApiResponse::responseError($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return ApiResponse::responseOk('', $userData);
    }

    /**
     * @SWG\Post(
     *     path="/users/check-logout",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @return JsonResponse
     */
    public function checkLogout()
    {
        $logoutTime = 60 * 60;
        $data = $this->repository->getLastAccessedDate($this->user->userid);
        if (!$data) {
            return ApiResponse::responseOk('', ['logout' => true]);
        }

        $lastAccessedDate = strtotime($data->last_accessed_date);
        $now = strtotime(Carbon::now());

        if ($lastAccessedDate <= $now - $logoutTime) {
            return ApiResponse::responseOk('', ['logout' => true]);
        }

        $resetTime = ($logoutTime - ($now - $lastAccessedDate)) * 1000;
        return ApiResponse::responseOk('', ['resetTime' => $resetTime]);
    }

    /**
     * @SWG\Post(
     *     path="/users/letter-info",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLetterInfo(Request $request)
    {
        $data = $this->repository->getLetterInfo($this->user->docid);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Get(
     *     path="/users/responsible",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @return JsonResponse
     */
    public function getResponsible()
    {
        $docId = $this->user->getDocIdOrZero();
        $data = $this->repository->getResponsible($docId);
        return ApiResponse::responseOk('', $data);
    }

    /**
     * @return string
     */
    public function getModelNamespace()
    {
        return self::BASE_MODEL_NAMESPACE;
    }
}
