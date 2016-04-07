<?php

namespace DentalSleepSolutions\Http\Requests;

class FlowsheetUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'formid'                => 'integer',
            'patientid'             => 'sometimes|required|integer',
            'inquiry_call_apt'      => 'date',
            'inquiry_call_comp'     => 'date',
            'send_np'               => 'string',
            'send_np_comp'          => 'date',
            'acquire_ss_apt'        => 'date',
            'acquire_ss_comp'       => 'date',
            'referral_dss_apt'      => 'date',
            'referral_dss_comp'     => 'date',
            'ss_requested_apt'      => 'string',
            'ss_requested_comp'     => 'string',
            'ss_received_apt'       => 'string',
            'ss_received_comp'      => 'string',
            'consultation_apt'      => 'date',
            'consultation_comp'     => 'string',
            'm_insurance_apt'       => 'date',
            'm_insurance_comp'      => 'date',
            'select_type '          => 'string',
            'exam_impressions_apt'  => 'date',
            'exam_impressions_comp' => 'string',
            'ltr_physicians_apt'    => 'string',
            'ltr_physicians_comp'   => 'string',
            'ltr_marketing_apt'     => 'string',
            'ltr_marketing_comp'    => 'string',
            'delivery_device_apt'   => 'string',
            'delivery_device_comp'  => 'string',
            'ltr_marketing_pt_apt'  => 'string',
            'ltr_marketing_pt_comp' => 'string',
            'ltr_corr_phy_apt'      => 'string',
            'ltr_corr_phy_comp'     => 'string',
            'first_check_apt'       => 'string',
            'first_check_comp'      => 'string',
            'add_check_apt'         => 'string',
            'add_check_comp'        => 'string',
            'home_sleep_apt'        => 'string',
            'home_sleep_comp'       => 'string',
            'further_checks_apt'    => 'string',
            'further_checks_comp'   => 'string',
            'comp_treatment_apt'    => 'string',
            'comp_treatment_comp'   => 'string',
            'ltr_copy_ss_apt'       => 'string',
            'ltr_copy_ss_comp'      => 'string',
            'annual_exam_apt'       => 'string',
            'annual_exam_comp'      => 'string',
            'pos_home_sleep_apt'    => 'string',
            'pos_home_sleep_comp'   => 'string',
            'ltr_corr_phy1_apt'     => 'string',
            'ltr_corr_phy1_comp'    => 'string',
            'ambulatory_ss_apt'     => 'date',
            'ambulatory_ss_comp'    => 'date',
            'diag_s_md_apt'         => 'string',
            'diag_s_md_comp'        => 'string',
            'psg_apt'               => 'string',
            'psg_comp'              => 'string',
            'pt_not_ds_apt'         => 'string',
            'pt_not_ds_comp'        => 'string',
            'not_candidate_apt'     => 'string',
            'not_candidate_comp'    => 'string',
            'fin_restraints_apt'    => 'string',
            'fin_restraints_comp'   => 'string',
            'pt_needing_apt'        => 'string',
            'pt_needing_comp'       => 'string',
            'inadequate_apt'        => 'string',
            'inadequate_comp'       => 'string',
            'userid'                => 'sometimes|required|integer',
            'docid'                 => 'sometimes|required|integer',
            'status'                => 'integer',
            'step'                  => 'integer'
        ];
    }
}
