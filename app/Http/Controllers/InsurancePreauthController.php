<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Resources\InsurancePreauth;
use DentalSleepSolutions\Contracts\Repositories\InsurancePreauth as InsPreauth;
use Illuminate\Http\Request;

class InsurancePreauthController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/insurance-preauth",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/InsurancePreauth"))
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
     *     path="/insurance-preauth/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/InsurancePreauth"))
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
     *     path="/insurance-preauth",
     *     @SWG\Parameter(name="doc_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="patient_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="ins_co", in="formData", type="string"),
     *     @SWG\Parameter(name="ins_rank", in="formData", type="string"),
     *     @SWG\Parameter(name="ins_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="patient_ins_group_id", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_ins_id", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_firstname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="patient_lastname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="patient_add1", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_add2", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_city", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_state", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_zip", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_dob", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="insured_first_name", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_last_name", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_dob", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="doc_npi", in="formData", type="string"),
     *     @SWG\Parameter(name="referring_doc_npi", in="formData", type="string"),
     *     @SWG\Parameter(name="trxn_code_amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="diagnosis_code", in="formData", type="string"),
     *     @SWG\Parameter(name="date_of_call", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="insurance_rep", in="formData", type="string"),
     *     @SWG\Parameter(name="call_reference_num", in="formData", type="string"),
     *     @SWG\Parameter(name="doc_medicare_npi", in="formData", type="string"),
     *     @SWG\Parameter(name="doc_tax_id_or_ssn", in="formData", type="string"),
     *     @SWG\Parameter(name="ins_effective_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ins_cal_year_start", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ins_cal_year_end", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="trxn_code_covered", in="formData", type="integer"),
     *     @SWG\Parameter(name="code_covered_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="has_out_of_network_benefits", in="formData", type="integer"),
     *     @SWG\Parameter(name="out_of_network_percentage", in="formData", type="integer"),
     *     @SWG\Parameter(name="is_hmo", in="formData", type="integer"),
     *     @SWG\Parameter(name="hmo_date_called", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="hmo_date_received", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="hmo_needs_auth", in="formData", type="integer"),
     *     @SWG\Parameter(name="hmo_auth_date_requested", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="hmo_auth_date_received", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="hmo_auth_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="in_network_percentage", in="formData", type="integer"),
     *     @SWG\Parameter(name="in_network_appeal_date_sent", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="in_network_appeal_date_received", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="is_pre_auth_required", in="formData", type="integer"),
     *     @SWG\Parameter(name="verbal_pre_auth_name", in="formData", type="string"),
     *     @SWG\Parameter(name="verbal_pre_auth_ref_num", in="formData", type="string"),
     *     @SWG\Parameter(name="verbal_pre_auth_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="written_pre_auth_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="written_pre_auth_date_received", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="front_office_request_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="patient_deductible", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="patient_amount_met", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="family_deductible", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="family_amount_met", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="deductible_reset_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="out_of_pocket_met", in="formData", type="integer"),
     *     @SWG\Parameter(name="patient_amount_left_to_meet", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="expected_insurance_payment", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="expected_patient_payment", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="network_benefits", in="formData", type="integer"),
     *     @SWG\Parameter(name="viewed", in="formData", type="integer"),
     *     @SWG\Parameter(name="date_completed", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="how_often", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_phone", in="formData", type="string", pattern="[0-9]{10}"),
     *     @SWG\Parameter(name="pre_auth_num", in="formData", type="string"),
     *     @SWG\Parameter(name="family_amount_left_to_meet", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="deductible_from", in="formData", type="integer"),
     *     @SWG\Parameter(name="reject_reason", in="formData", type="string"),
     *     @SWG\Parameter(name="invoice_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="invoice_amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="invoice_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="invoice_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="updated_by", in="formData", type="integer"),
     *     @SWG\Parameter(name="doc_name", in="formData", type="string"),
     *     @SWG\Parameter(name="doc_practice", in="formData", type="string"),
     *     @SWG\Parameter(name="doc_address", in="formData", type="string"),
     *     @SWG\Parameter(name="doc_phone", in="formData", type="string", pattern="[0-9]{10}"),
     *     @SWG\Parameter(name="in_deductible_from", in="formData", type="integer"),
     *     @SWG\Parameter(name="in_patient_deductible", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_patient_amount_met", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_patient_amount_left_to_meet", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_family_deductible", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_family_amount_met", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_family_amount_left_to_meet", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_deductible_reset_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="in_out_of_pocket_met", in="formData", type="integer"),
     *     @SWG\Parameter(name="in_expected_insurance_payment", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_expected_patient_payment", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_call_reference_num", in="formData", type="string"),
     *     @SWG\Parameter(name="has_in_network_benefits", in="formData", type="integer"),
     *     @SWG\Parameter(name="in_is_pre_auth_required", in="formData", type="integer"),
     *     @SWG\Parameter(name="in_verbal_pre_auth_name", in="formData", type="string"),
     *     @SWG\Parameter(name="in_verbal_pre_auth_ref_num", in="formData", type="string"),
     *     @SWG\Parameter(name="in_verbal_pre_auth_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="in_written_pre_auth_date_received", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="in_pre_auth_num", in="formData", type="string"),
     *     @SWG\Parameter(name="in_written_pre_auth_notes", in="formData", type="string"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/InsurancePreauth"))
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
     *     path="/insurance-preauth/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="doc_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="patient_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="ins_co", in="formData", type="string"),
     *     @SWG\Parameter(name="ins_rank", in="formData", type="string"),
     *     @SWG\Parameter(name="ins_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="patient_ins_group_id", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_ins_id", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_firstname", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_lastname", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_add1", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_add2", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_city", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_state", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_zip", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_dob", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="insured_first_name", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_last_name", in="formData", type="string"),
     *     @SWG\Parameter(name="insured_dob", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="doc_npi", in="formData", type="string"),
     *     @SWG\Parameter(name="referring_doc_npi", in="formData", type="string"),
     *     @SWG\Parameter(name="trxn_code_amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="diagnosis_code", in="formData", type="string"),
     *     @SWG\Parameter(name="date_of_call", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="insurance_rep", in="formData", type="string"),
     *     @SWG\Parameter(name="call_reference_num", in="formData", type="string"),
     *     @SWG\Parameter(name="doc_medicare_npi", in="formData", type="string"),
     *     @SWG\Parameter(name="doc_tax_id_or_ssn", in="formData", type="string"),
     *     @SWG\Parameter(name="ins_effective_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ins_cal_year_start", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ins_cal_year_end", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="trxn_code_covered", in="formData", type="integer"),
     *     @SWG\Parameter(name="code_covered_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="has_out_of_network_benefits", in="formData", type="integer"),
     *     @SWG\Parameter(name="out_of_network_percentage", in="formData", type="integer"),
     *     @SWG\Parameter(name="is_hmo", in="formData", type="integer"),
     *     @SWG\Parameter(name="hmo_date_called", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="hmo_date_received", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="hmo_needs_auth", in="formData", type="integer"),
     *     @SWG\Parameter(name="hmo_auth_date_requested", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="hmo_auth_date_received", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="hmo_auth_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="in_network_percentage", in="formData", type="integer"),
     *     @SWG\Parameter(name="in_network_appeal_date_sent", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="in_network_appeal_date_received", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="is_pre_auth_required", in="formData", type="integer"),
     *     @SWG\Parameter(name="verbal_pre_auth_name", in="formData", type="string"),
     *     @SWG\Parameter(name="verbal_pre_auth_ref_num", in="formData", type="string"),
     *     @SWG\Parameter(name="verbal_pre_auth_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="written_pre_auth_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="written_pre_auth_date_received", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="front_office_request_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="patient_deductible", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="patient_amount_met", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="family_deductible", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="family_amount_met", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="deductible_reset_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="out_of_pocket_met", in="formData", type="integer"),
     *     @SWG\Parameter(name="patient_amount_left_to_meet", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="expected_insurance_payment", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="expected_patient_payment", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="network_benefits", in="formData", type="integer"),
     *     @SWG\Parameter(name="viewed", in="formData", type="integer"),
     *     @SWG\Parameter(name="date_completed", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="how_often", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_phone", in="formData", type="string", pattern="[0-9]{10}"),
     *     @SWG\Parameter(name="pre_auth_num", in="formData", type="string"),
     *     @SWG\Parameter(name="family_amount_left_to_meet", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="deductible_from", in="formData", type="integer"),
     *     @SWG\Parameter(name="reject_reason", in="formData", type="string"),
     *     @SWG\Parameter(name="invoice_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="invoice_amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="invoice_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="invoice_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="updated_by", in="formData", type="integer"),
     *     @SWG\Parameter(name="doc_name", in="formData", type="string"),
     *     @SWG\Parameter(name="doc_practice", in="formData", type="string"),
     *     @SWG\Parameter(name="doc_address", in="formData", type="string"),
     *     @SWG\Parameter(name="doc_phone", in="formData", type="string", pattern="[0-9]{10}"),
     *     @SWG\Parameter(name="in_deductible_from", in="formData", type="integer"),
     *     @SWG\Parameter(name="in_patient_deductible", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_patient_amount_met", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_patient_amount_left_to_meet", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_family_deductible", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_family_amount_met", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_family_amount_left_to_meet", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_deductible_reset_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="in_out_of_pocket_met", in="formData", type="integer"),
     *     @SWG\Parameter(name="in_expected_insurance_payment", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_expected_patient_payment", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="in_call_reference_num", in="formData", type="string"),
     *     @SWG\Parameter(name="has_in_network_benefits", in="formData", type="integer"),
     *     @SWG\Parameter(name="in_is_pre_auth_required", in="formData", type="integer"),
     *     @SWG\Parameter(name="in_verbal_pre_auth_name", in="formData", type="string"),
     *     @SWG\Parameter(name="in_verbal_pre_auth_ref_num", in="formData", type="string"),
     *     @SWG\Parameter(name="in_verbal_pre_auth_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="in_written_pre_auth_date_received", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="in_pre_auth_num", in="formData", type="string"),
     *     @SWG\Parameter(name="in_written_pre_auth_notes", in="formData", type="string"),
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
     *     path="/insurance-preauth/{id}",
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

    public function getByType($type, InsPreauth $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        switch ($type) {
            case 'completed':
                $data = $resources->getCompleted($docId);
                break;
            case 'pending':
                $data = $resources->getPending($docId);
                break;
            case 'rejected':
                $data = $resources->getRejected($docId);
                break;
            default:
                $data = [];
                break;
        }

        return ApiResponse::responseOk('', $data);
    }

    public function getPendingVOBByContactId(InsurancePreauth $resource, Request $request)
    {
        $contactId = $request->input('contact_id', 0);
        $data = $resource->getPendingVOBByContactId($contactId);
      
        return ApiResponse::responseOk('', $data);
    }

    public function find(InsPreauth $resources, Request $request)
    {
        $docId = $this->currentUser->docid ?: 0;

        $pageNumber = $request->input('page');
        $vobsPerPage = $request->input('vobsPerPage');
        $sortColumn = $request->input('sortColumn');
        $sortDir = $request->input('sortDir');
        $viewed = $request->input('viewed');

        $data = $resources->getListVobs(
            $docId, 
            $viewed, 
            $sortColumn,
            $sortDir,
            $vobsPerPage,
            $pageNumber
        );

        return ApiResponse::responseOk('', $data);
    }

    public function getSingular()
    {
        return 'InsurancePreauth';
    }
}
