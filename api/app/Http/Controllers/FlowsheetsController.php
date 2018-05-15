<?php

namespace DentalSleepSolutions\Http\Controllers;

/**
 * @todo: restore API tests if needed or delete the controller
 */
class FlowsheetsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/flowsheets",
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
     *                         @SWG\Items(ref="#/definitions/Flowsheet")
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
     *     path="/flowsheets/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Flowsheet")
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
     *     path="/flowsheets",
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="inquiry_call_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="inquiry_call_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="send_np", in="formData", type="string"),
     *     @SWG\Parameter(name="send_np_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="acquire_ss_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="acquire_ss_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="referral_dss_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="referral_dss_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ss_requested_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ss_requested_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ss_received_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ss_received_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="consultation_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="consultation_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="m_insurance_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="m_insurance_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="select_type ", in="formData", type="string"),
     *     @SWG\Parameter(name="exam_impressions_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="exam_impressions_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_physicians_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_physicians_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_marketing_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_marketing_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="delivery_device_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="delivery_device_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_marketing_pt_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_marketing_pt_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_corr_phy_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_corr_phy_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="first_check_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="first_check_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="add_check_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="add_check_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="home_sleep_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="home_sleep_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="further_checks_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="further_checks_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="comp_treatment_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="comp_treatment_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_copy_ss_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_copy_ss_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="annual_exam_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="annual_exam_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="pos_home_sleep_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="pos_home_sleep_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_corr_phy1_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_corr_phy1_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ambulatory_ss_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ambulatory_ss_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="diag_s_md_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="diag_s_md_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="psg_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="psg_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="pt_not_ds_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="pt_not_ds_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="not_candidate_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="not_candidate_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="fin_restraints_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="fin_restraints_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="pt_needing_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="pt_needing_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="inadequate_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="inadequate_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="step", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Flowsheet")
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
     *     path="/flowsheets/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="inquiry_call_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="inquiry_call_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="send_np", in="formData", type="string"),
     *     @SWG\Parameter(name="send_np_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="acquire_ss_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="acquire_ss_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="referral_dss_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="referral_dss_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ss_requested_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ss_requested_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ss_received_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ss_received_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="consultation_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="consultation_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="m_insurance_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="m_insurance_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="select_type ", in="formData", type="string"),
     *     @SWG\Parameter(name="exam_impressions_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="exam_impressions_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_physicians_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_physicians_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_marketing_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_marketing_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="delivery_device_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="delivery_device_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_marketing_pt_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_marketing_pt_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_corr_phy_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_corr_phy_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="first_check_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="first_check_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="add_check_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="add_check_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="home_sleep_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="home_sleep_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="further_checks_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="further_checks_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="comp_treatment_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="comp_treatment_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_copy_ss_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_copy_ss_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="annual_exam_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="annual_exam_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="pos_home_sleep_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="pos_home_sleep_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_corr_phy1_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="ltr_corr_phy1_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="ambulatory_ss_apt", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ambulatory_ss_comp", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="diag_s_md_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="diag_s_md_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="psg_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="psg_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="pt_not_ds_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="pt_not_ds_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="not_candidate_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="not_candidate_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="fin_restraints_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="fin_restraints_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="pt_needing_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="pt_needing_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="inadequate_apt", in="formData", type="string"),
     *     @SWG\Parameter(name="inadequate_comp", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="step", in="formData", type="integer"),
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
     *     path="/flowsheets/{id}",
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
