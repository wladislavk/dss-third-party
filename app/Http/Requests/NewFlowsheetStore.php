<?php

namespace DentalSleepSolutions\Http\Requests;

class NewFlowsheetStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'formid'                   => 'integer',
            'patientid'                => 'required|integer',
            'inquiry_call_comp'        => 'required|date',
            'send_np'                  => 'string',
            'send_np_comp'             => 'string',
            'acquire_ss_apt'           => 'string',
            'acquire_ss_comp'          => 'date',
            'pt_not_ss'                => 'string',
            'ss_date_requested'        => 'string',
            'ss_date_received'         => 'string',
            'date_referred'            => 'date',
            'dss_dentists'             => 'string',
            'ss_requested_apt'         => 'date',
            'ss_requested_comp'        => 'date',
            'ss_received_apt'          => 'date',
            'ss_received_comp'         => 'date',
            'consultation_apt'         => 'date',
            'consultation_comp'        => 'string',
            'm_insurance_date'         => 'date',
            'select_type'              => 'string',
            'exam_impressions_apt'     => 'string',
            'exam_impressions_comp'    => 'string',
            'dsr_prepared'             => 'string',
            'dsr_sent'                 => 'string',
            'delivery_device_apt'      => 'string',
            'delivery_device_comp'     => 'string',
            'dsr_date_delivered'       => 'string',
            'ltr_phy_prepared'         => 'string',
            'ltr_phy_sent'             => 'string',
            'first_check_apt'          => 'string',
            'first_check_comp'         => 'string',
            'add_check_apt'            => 'string',
            'add_check_comp'           => 'string',
            'home_sleep_apt'           => 'string',
            'home_sleep_comp'          => 'string',
            'further_checks_apt'       => 'string',
            'further_checks_comp'      => 'string',
            'comp_treatment_date'      => 'string',
            'portable_date_comp'       => 'string',
            'treatment_success'        => 'string',
            'ltr_doc_ss_date_prepared' => 'string',
            'ltr_doc_ss_date_sent'     => 'string',
            'annual_exam_apt'          => 'string',
            'annual_exam_comp'         => 'string',
            'ltr_doc_pt_date_prepared' => 'string',
            'ltr_doc_pt_date_sent'     => 'string',
            'ambulatory_ss_apt'        => 'date',
            'ambulatory_ss_comp'       => 'date',
            'diag_s_md_sent'           => 'date',
            'diag_s_md_received'       => 'date',
            'psg_apt'                  => 'date',
            'psg_comp'                 => 'string',
            'sleep_lab'                => 'string',
            'lomn'                     => 'string',
            'rxfrommd'                 => 'string',
            'not_candidate'            => 'string',
            'financial_restraints'     => 'string',
            'pt_needing_dental_work'   => 'string',
            'inadequate_dentition'     => 'string',
            'pt_not_ds_other'          => 'string',
            'ltr_pp_date_prepared'     => 'date',
            'ltr_pp_date_sent'         => 'string',
            'userid'                   => 'required|integer',
            'docid'                    => 'required|integer',
            'status'                   => 'integer',
            'step'                     => 'integer',
            'sstep'                    => 'integer'
        ];
    }
}
