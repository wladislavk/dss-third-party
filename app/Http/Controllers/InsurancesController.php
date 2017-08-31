<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\InsuranceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Helpers\PendingClaimRemover;
use DentalSleepSolutions\Helpers\UnmailedClaimsRetriever;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\Request;

class InsurancesController extends BaseRestController
{
    const DSS_USER_TYPE_FRANCHISEE = 1;
    const DSS_USER_TYPE_SOFTWARE   = 2;

    // Transaction statuses (ledger)
    const DSS_TRXN_NA = 0; // trxn created/updated, but not filed.

    /** @var InsuranceRepository */
    protected $repository;

    /**
     * @SWG\Get(
     *     path="/insurances",
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
     *                         @SWG\Items(ref="#/definitions/Insurance")
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
     *     path="/insurances/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Insurance")
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
     *     path="/insurances",
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="pica1", in="formData", type="string"),
     *     @SWG\Parameter(name="pica2", in="formData", type="string"),
     *     @SWG\Parameter(name="pica3", in="formData", type="string"),
     *     @SWG\Parameter(name="insurance_type", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_id_number", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_firstname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="patient_lastname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="patient_middle", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_dob", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_sex", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_firstname", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_lastname", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_middle", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_address", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="patient_relation_insured", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_address", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_city", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_state", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_status", in="formData", type="string", pattern="^~[A-Za-z]+~$"),
     *     @SWG\Parameter(name="insured_city", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_state", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="patient_phone_code", in="formData", type="string", pattern="^[0-9]{3}$"),
     *     @SWG\Parameter(name="patient_phone", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="insured_phone_code", in="formData", type="string", pattern="^[0-9]{3}$"),
     *     @SWG\Parameter(name="insured_phone", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_policy_group_feca", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_dob", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_sex", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_employer_school_name", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_insurance_plan", in="formData", type="string"),
     *     @SWG\Parameter(name="other_insured_insurance_plan", in="formData", type="string"),
     *     @SWG\Parameter(name="another_plan", in="formData", type="string", pattern="^(?:NO|YES)$"),
     *     @SWG\Parameter(name="patient_signature", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_signed_date", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_signature", in="formData", type="string"),
     *     @SWG\Parameter(name="diagnosis_1", in="formData", type="string"),
     *     @SWG\Parameter(name="diagnosis_2", in="formData", type="string"),
     *     @SWG\Parameter(name="diagnosis_3", in="formData", type="string"),
     *     @SWG\Parameter(name="diagnosis_4", in="formData", type="string"),
     *     @SWG\Parameter(name="service_date1_from", in="formData", type="string"),
     *     @SWG\Parameter(name="service_date1_to", in="formData", type="string"),
     *     @SWG\Parameter(name="place_of_service1", in="formData", type="string"),
     *     @SWG\Parameter(name="cpt_hcpcs1", in="formData", type="string", pattern="^[A-Z][0-9]{4}$"),
     *     @SWG\Parameter(name="s_charges1_1", in="formData", type="string"),
     *     @SWG\Parameter(name="s_charges1_2", in="formData", type="string"),
     *     @SWG\Parameter(name="federal_tax_id_number", in="formData", type="string"),
     *     @SWG\Parameter(name="ein", in="formData", type="string"),
     *     @SWG\Parameter(name="accept_assignment", in="formData", type="string", pattern="^(?:Yes|No|A|C)$"),
     *     @SWG\Parameter(name="total_charge", in="formData", type="string", pattern="^(?:[1-9]+[0-9]*\,)?[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="amount_paid", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="balance_due", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="signature_physician", in="formData", type="string"),
     *     @SWG\Parameter(name="physician_signed_date", in="formData", type="string"),
     *     @SWG\Parameter(name="service_facility_info_name", in="formData", type="string"),
     *     @SWG\Parameter(name="service_facility_info_address", in="formData", type="string"),
     *     @SWG\Parameter(name="service_facility_info_city", in="formData", type="string"),
     *     @SWG\Parameter(name="service_info_a", in="formData", type="string"),
     *     @SWG\Parameter(name="billing_provider_phone_code", in="formData", type="string", pattern="[0-9]{3}"),
     *     @SWG\Parameter(name="billing_provider_phone", in="formData", type="string"),
     *     @SWG\Parameter(name="billing_provider_name", in="formData", type="string"),
     *     @SWG\Parameter(name="billing_provider_address", in="formData", type="string"),
     *     @SWG\Parameter(name="billing_provider_city", in="formData", type="string"),
     *     @SWG\Parameter(name="billing_provider_a", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="card", in="formData", type="integer"),
     *     @SWG\Parameter(name="dispute_reason", in="formData", type="string"),
     *     @SWG\Parameter(name="primary_fdf", in="formData", type="string", pattern="^fdf_[0-9]_[0-9]{2}_[0-9]{14}\.fdf$"),
     *     @SWG\Parameter(name="secondary_fdf", in="formData", type="string", pattern="^fdf_[0-9]_[0-9]{2}_[0-9]{14}\.fdf$"),
     *     @SWG\Parameter(name="producer", in="formData", type="integer"),
     *     @SWG\Parameter(name="mailed_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="eligible_response", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_eligible_payer_id", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_eligible_payer_name", in="formData", type="string"),
     *     @SWG\Parameter(name="eligible_token", in="formData", type="string"),
     *     @SWG\Parameter(name="percase_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="percase_name", in="formData", type="string"),
     *     @SWG\Parameter(name="percase_amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="percase_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="percase_invoice", in="formData", type="integer"),
     *     @SWG\Parameter(name="primary_claim_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="fo_paid_viewed", in="formData", type="integer"),
     *     @SWG\Parameter(name="bo_paid_viewed", in="formData", type="integer"),
     *     @SWG\Parameter(name="primary_claim_version", in="formData", type="integer"),
     *     @SWG\Parameter(name="secondary_claim_version", in="formData", type="integer"),
     *     @SWG\Parameter(name="icd_ind", in="formData", type="integer"),
     *     @SWG\Parameter(name="name_referring_provider_qualifier", in="formData", type="string"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Insurance")
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
     *     path="/insurances/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="pica1", in="formData", type="string"),
     *     @SWG\Parameter(name="pica2", in="formData", type="string"),
     *     @SWG\Parameter(name="pica3", in="formData", type="string"),
     *     @SWG\Parameter(name="insurance_type", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_id_number", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_firstname", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_lastname", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_middle", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_dob", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_sex", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_firstname", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_lastname", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_middle", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_address", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_relation_insured", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_address", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_city", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_state", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_status", in="formData", type="string", pattern="^~[A-Za-z]+~$"),
     *     @SWG\Parameter(name="insured_city", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_state", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="patient_phone_code", in="formData", type="string", pattern="^[0-9]{3}$"),
     *     @SWG\Parameter(name="patient_phone", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="insured_phone_code", in="formData", type="string", pattern="^[0-9]{3}$"),
     *     @SWG\Parameter(name="insured_phone", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_policy_group_feca", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_dob", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_sex", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_employer_school_name", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_insurance_plan", in="formData", type="string"),
     *     @SWG\Parameter(name="other_insured_insurance_plan", in="formData", type="string"),
     *     @SWG\Parameter(name="another_plan", in="formData", type="string", pattern="^(?:NO|YES)$"),
     *     @SWG\Parameter(name="patient_signature", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_signed_date", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_signature", in="formData", type="string"),
     *     @SWG\Parameter(name="diagnosis_1", in="formData", type="string"),
     *     @SWG\Parameter(name="diagnosis_2", in="formData", type="string"),
     *     @SWG\Parameter(name="diagnosis_3", in="formData", type="string"),
     *     @SWG\Parameter(name="diagnosis_4", in="formData", type="string"),
     *     @SWG\Parameter(name="service_date1_from", in="formData", type="string"),
     *     @SWG\Parameter(name="service_date1_to", in="formData", type="string"),
     *     @SWG\Parameter(name="place_of_service1", in="formData", type="string"),
     *     @SWG\Parameter(name="cpt_hcpcs1", in="formData", type="string", pattern="^[A-Z][0-9]{4}$"),
     *     @SWG\Parameter(name="s_charges1_1", in="formData", type="string"),
     *     @SWG\Parameter(name="s_charges1_2", in="formData", type="string"),
     *     @SWG\Parameter(name="federal_tax_id_number", in="formData", type="string"),
     *     @SWG\Parameter(name="ein", in="formData", type="string"),
     *     @SWG\Parameter(name="accept_assignment", in="formData", type="string", pattern="^(?:Yes|No|A|C)$"),
     *     @SWG\Parameter(name="total_charge", in="formData", type="string", pattern="^(?:[1-9]+[0-9]*\,)?[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="amount_paid", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="balance_due", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="signature_physician", in="formData", type="string"),
     *     @SWG\Parameter(name="physician_signed_date", in="formData", type="string"),
     *     @SWG\Parameter(name="service_facility_info_name", in="formData", type="string"),
     *     @SWG\Parameter(name="service_facility_info_address", in="formData", type="string"),
     *     @SWG\Parameter(name="service_facility_info_city", in="formData", type="string"),
     *     @SWG\Parameter(name="service_info_a", in="formData", type="string"),
     *     @SWG\Parameter(name="billing_provider_phone_code", in="formData", type="string", pattern="[0-9]{3}"),
     *     @SWG\Parameter(name="billing_provider_phone", in="formData", type="string"),
     *     @SWG\Parameter(name="billing_provider_name", in="formData", type="string"),
     *     @SWG\Parameter(name="billing_provider_address", in="formData", type="string"),
     *     @SWG\Parameter(name="billing_provider_city", in="formData", type="string"),
     *     @SWG\Parameter(name="billing_provider_a", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="card", in="formData", type="integer"),
     *     @SWG\Parameter(name="dispute_reason", in="formData", type="string"),
     *     @SWG\Parameter(name="primary_fdf", in="formData", type="string", pattern="^fdf_[0-9]_[0-9]{2}_[0-9]{14}\.fdf$"),
     *     @SWG\Parameter(name="secondary_fdf", in="formData", type="string", pattern="^fdf_[0-9]_[0-9]{2}_[0-9]{14}\.fdf$"),
     *     @SWG\Parameter(name="producer", in="formData", type="integer"),
     *     @SWG\Parameter(name="mailed_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="eligible_response", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_eligible_payer_id", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_eligible_payer_name", in="formData", type="string"),
     *     @SWG\Parameter(name="eligible_token", in="formData", type="string"),
     *     @SWG\Parameter(name="percase_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="percase_name", in="formData", type="string"),
     *     @SWG\Parameter(name="percase_amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="percase_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="percase_invoice", in="formData", type="integer"),
     *     @SWG\Parameter(name="primary_claim_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="fo_paid_viewed", in="formData", type="integer"),
     *     @SWG\Parameter(name="bo_paid_viewed", in="formData", type="integer"),
     *     @SWG\Parameter(name="primary_claim_version", in="formData", type="integer"),
     *     @SWG\Parameter(name="secondary_claim_version", in="formData", type="integer"),
     *     @SWG\Parameter(name="icd_ind", in="formData", type="integer"),
     *     @SWG\Parameter(name="name_referring_provider_qualifier", in="formData", type="string"),
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
     *     path="/insurances/{id}",
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
     *     path="/insurances/rejected",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRejected(Request $request)
    {
        $patientId = $request->input('patientId', 0);

        $data = $this->repository->getRejected($patientId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/insurances/pending-claims",
     *     @SWG\Parameter(name="type", in="path", type="string", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPendingFrontOfficeClaims()
    {
        $data = $this->repository->getPendingClaims($this->user->docid);
        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/insurances/unmailed-claims",
     *     @SWG\Parameter(name="type", in="path", type="string", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param UnmailedClaimsRetriever $unmailedClaimsRetriever
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnmailedFrontOfficeClaims(UnmailedClaimsRetriever $unmailedClaimsRetriever)
    {
        $data = $unmailedClaimsRetriever->getUnmailedClaims($this->user->docid, $this->user->user_type);
        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/insurances/rejected-claims",
     *     @SWG\Parameter(name="type", in="path", type="string", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRejectedFrontOfficeClaims()
    {
        $data = $this->repository->getRejectedClaims($this->user->docid);
        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/insurances/remove-claim",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param PendingClaimRemover $pendingClaimRemover
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeClaim(PendingClaimRemover $pendingClaimRemover, Request $request)
    {
        $claimId = $request->input('claim_id', 0);

        try {
            $pendingClaimRemover->removePendingClaim($claimId);
        } catch (GeneralException $e) {
            return ApiResponse::responseError('Error deleting');
        }
        return ApiResponse::responseOk('Deleted Successfully');
    }
}
