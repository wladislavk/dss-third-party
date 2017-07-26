<?php

namespace DentalSleepSolutions\Http\Controllers;

class NewFlowsheetsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/new-flowsheets",
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
     *                         @SWG\Items(ref="#/definitions/NewFlowsheet")
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
     *     path="/new-flowsheets/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/NewFlowsheet")
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
     *     path="/new-flowsheets",
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="inquiry_call_comp", in="formData", type="string", format="dateTime", required=true),
     *     @SWG\Parameter(name="send_np", in="formData", type="string"),
     *     @SWG\Parameter(name="send_np_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="acquire_ss_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="acquire_ss_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="pt_not_ss", in="formData", type="string"),
     *     @SWG\Parameter(name="ss_date_requested", in="formData", type="string"),
     *     @SWG\Parameter(name="ss_date_received", in="formData", type="string"),
     *     @SWG\Parameter(name="date_referred", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="dss_dentists", in="formData", type="string"),
     *     @SWG\Parameter(name="ss_requested_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ss_requested_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ss_received_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ss_received_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="consultation_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="consultation_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="m_insurance_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="select_type", in="formData", type="string"),
     *     @SWG\Parameter(name="exam_impressions_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="exam_impressions_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="dsr_prepared", in="formData", type="string"),
     *     @SWG\Parameter(name="dsr_sent", in="formData", type="string"),
     *     @SWG\Parameter(name="delivery_device_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="delivery_device_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="dsr_date_delivered", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_phy_prepared", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_phy_sent", in="formData", type="string"),
     *     @SWG\Parameter(name="first_check_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="first_check_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="add_check_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="add_check_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="home_sleep_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="home_sleep_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="further_checks_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="further_checks_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="comp_treatment_date", in="formData", type="string"),
     *     @SWG\Parameter(name="portable_date_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="treatment_success", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_doc_ss_date_prepared", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_doc_ss_date_sent", in="formData", type="string"),
     *     @SWG\Parameter(name="annual_exam_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="annual_exam_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_doc_pt_date_prepared", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_doc_pt_date_sent", in="formData", type="string"),
     *     @SWG\Parameter(name="ambulatory_ss_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ambulatory_ss_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="diag_s_md_sent", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="diag_s_md_received", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="psg_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="psg_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_lab", in="formData", type="string"),
     *     @SWG\Parameter(name="lomn", in="formData", type="string"),
     *     @SWG\Parameter(name="rxfrommd", in="formData", type="string"),
     *     @SWG\Parameter(name="not_candidate", in="formData", type="string"),
     *     @SWG\Parameter(name="financial_restraints", in="formData", type="string"),
     *     @SWG\Parameter(name="pt_needing_dental_work", in="formData", type="string"),
     *     @SWG\Parameter(name="inadequate_dentition", in="formData", type="string"),
     *     @SWG\Parameter(name="pt_not_ds_other", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_pp_date_prepared", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ltr_pp_date_sent", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="step", in="formData", type="integer"),
     *     @SWG\Parameter(name="sstep", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/NewFlowsheet")
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
     *     path="/new-flowsheets/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="inquiry_call_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="send_np", in="formData", type="string"),
     *     @SWG\Parameter(name="send_np_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="acquire_ss_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="acquire_ss_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="pt_not_ss", in="formData", type="string"),
     *     @SWG\Parameter(name="ss_date_requested", in="formData", type="string"),
     *     @SWG\Parameter(name="ss_date_received", in="formData", type="string"),
     *     @SWG\Parameter(name="date_referred", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="dss_dentists", in="formData", type="string"),
     *     @SWG\Parameter(name="ss_requested_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ss_requested_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ss_received_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ss_received_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="consultation_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="consultation_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="m_insurance_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="select_type", in="formData", type="string"),
     *     @SWG\Parameter(name="exam_impressions_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="exam_impressions_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="dsr_prepared", in="formData", type="string"),
     *     @SWG\Parameter(name="dsr_sent", in="formData", type="string"),
     *     @SWG\Parameter(name="delivery_device_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="delivery_device_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="dsr_date_delivered", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_phy_prepared", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_phy_sent", in="formData", type="string"),
     *     @SWG\Parameter(name="first_check_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="first_check_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="add_check_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="add_check_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="home_sleep_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="home_sleep_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="further_checks_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="further_checks_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="comp_treatment_date", in="formData", type="string"),
     *     @SWG\Parameter(name="portable_date_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="treatment_success", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_doc_ss_date_prepared", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_doc_ss_date_sent", in="formData", type="string"),
     *     @SWG\Parameter(name="annual_exam_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="annual_exam_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_doc_pt_date_prepared", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_doc_pt_date_sent", in="formData", type="string"),
     *     @SWG\Parameter(name="ambulatory_ss_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ambulatory_ss_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="diag_s_md_sent", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="diag_s_md_received", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="psg_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="psg_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_lab", in="formData", type="string"),
     *     @SWG\Parameter(name="lomn", in="formData", type="string"),
     *     @SWG\Parameter(name="rxfrommd", in="formData", type="string"),
     *     @SWG\Parameter(name="not_candidate", in="formData", type="string"),
     *     @SWG\Parameter(name="financial_restraints", in="formData", type="string"),
     *     @SWG\Parameter(name="pt_needing_dental_work", in="formData", type="string"),
     *     @SWG\Parameter(name="inadequate_dentition", in="formData", type="string"),
     *     @SWG\Parameter(name="pt_not_ds_other", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_pp_date_prepared", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ltr_pp_date_sent", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="step", in="formData", type="integer"),
     *     @SWG\Parameter(name="sstep", in="formData", type="integer"),
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
     *     path="/new-flowsheets/{id}",
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
}
