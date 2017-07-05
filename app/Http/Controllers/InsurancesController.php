<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Resources\Insurance;
use DentalSleepSolutions\Contracts\Resources\Ledger;
use DentalSleepSolutions\Contracts\Repositories\Insurances;
use Illuminate\Http\Request;

class InsurancesController extends BaseRestController
{
    const DSS_USER_TYPE_FRANCHISEE = 1;
    const DSS_USER_TYPE_SOFTWARE   = 2;

    // Transaction statuses (ledger)
    const DSS_TRXN_NA = 0; // trxn created/updated, but not filed.

    /**
     * @SWG\Get(
     *     path="/insurances",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/Insurance"))
     *                 )
     *             )
     *         }
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
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Insurance"))
     *             )
     *         }
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
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Insurance"))
     *             )
     *         }
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
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
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Insurance"))
     *             )
     *         }
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

    public function getRejected(Insurances $resources, Request $request)
    {
        $patientId = $request->input('patientId');

        $data = $resources->getRejected($patientId);

        return ApiResponse::responseOk('', $data);
    }

    public function getFrontOfficeClaims($type, Insurances $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $isUserTypeSoftware = ($this->currentUser->user_type == self::DSS_USER_TYPE_SOFTWARE);

        switch ($type) {
            case 'pending-claims':
                $data = $resources->getPendingClaims($docId);
                break;
            case 'unmailed-claims':
                $data = $resources->getUnmailedClaims($docId, $isUserTypeSoftware);
                break;
            case 'rejected-claims':
                $data = $resources->getRejectedClaims($docId);
                break;
            default:
                $data = [];
                break;
        }

        return ApiResponse::responseOk('', $data);
    }

    public function removeClaim(Insurance $resource, Ledger $ledgerResource, Request $request)
    {
        $claimId = $request->input('claim_id', 0);

        $isSuccess = $resource->removePendingClaim($claimId);

        if ($isSuccess) {
            $ledgerResource->updateWherePrimaryClaimId($claimId, [
                'primary_claim_id' => null,
                'status'           => self::DSS_TRXN_NA,
            ]);

            return ApiResponse::responseOk('Deleted Successfully');
        } else {
            return ApiResponse::responseError('Error deleting');
        }
    }
}
