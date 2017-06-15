<?php

namespace DentalSleepSolutions\Http\Requests;

class SummaryStore extends AbstractStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'formid'                           => 'integer',
            'patientid'                        => 'required|integer',
            'patient_name'                     => 'string',
            'patient_dob'                      => 'string',
            'docpcp'                           => 'regex:/^[0-9]+$/',
            'docsmd'                           => 'regex:/^[0-9]+$/',
            'docomd1'                          => 'regex:/^[0-9]+$/',
            'docomd2'                          => 'regex:/^[0-9]+$/',
            'docdds'                           => 'string',
            'osite'                            => 'string',
            'referral_source'                  => 'string',
            'reason_seeking_tx'                => 'string',
            'symptoms_osa'                     => 'string',
            'bed_time_partner'                 => 'string',
            'snoring'                          => 'string',
            'apnea'                            => 'string',
            'history_surgery'                  => 'string',
            'tried_cpap'                       => 'string',
            'cpap_totalnights'                 => 'integer',
            'fna'                              => 'string',
            'cpap_date'                        => 'string',
            'problem_cpap'                     => 'string',
            'wearing_cpap'                     => 'string',
            'max_translation_from'             => 'string',
            'max_translation_to'               => 'string',
            'max_translation_equal'            => 'string',
            'initial_device_titration_1'       => 'regex:/^[0-9]+$/',
            'initial_device_titration_equal_h' => 'regex:/^[0-9]+$/',
            'initial_device_titration_equal_v' => 'regex:/^[0-9]+$/',
            'optimum_echovision_ver'           => 'regex:/^[0-9]+$/',
            'optimum_echovision_hor'           => 'regex:/^[0-9]+$/',
            'type_device'                      => 'string',
            'personal'                         => 'string',
            'lab_name'                         => 'string',
            'sti_test_1'                       => 'string',
            'sti_test_2'                       => 'string',
            'sti_test_3'                       => 'string',
            'sti_test_4'                       => 'string',
            'sti_date_1'                       => 'date',
            'sti_date_2'                       => 'date',
            'sti_date_3'                       => 'date',
            'sti_date_4'                       => 'date',
            'sti_ahi_1'                        => 'string',
            'sti_ahi_2'                        => 'string',
            'sti_ahi_3'                        => 'string',
            'sti_ahi_4'                        => 'string',
            'sti_rdi_1'                        => 'string',
            'sti_rdi_2'                        => 'string',
            'sti_rdi_3'                        => 'string',
            'sti_rdi_4'                        => 'string',
            'sti_supine_ahi_1'                 => 'string',
            'sti_supine_ahi_2'                 => 'string',
            'sti_supine_ahi_3'                 => 'string',
            'sti_supine_ahi_4'                 => 'string',
            'sti_supine_rdi_1'                 => 'string',
            'sti_supine_rdi_2'                 => 'string',
            'sti_supine_rdi_3'                 => 'string',
            'sti_supine_rdi_4'                 => 'string',
            'sti_lsat_1'                       => 'string',
            'sti_lsat_2'                       => 'string',
            'sti_lsat_3'                       => 'string',
            'sti_lsat_4'                       => 'string',
            'sti_titration_1'                  => 'string',
            'sti_titration_2'                  => 'string',
            'sti_titration_3'                  => 'string',
            'sti_titration_4'                  => 'string',
            'sti_cpap_p_1'                     => 'string',
            'sti_cpap_p_2'                     => 'string',
            'sti_cpap_p_3'                     => 'string',
            'sti_cpap_p_4'                     => 'string',
            'sti_apnea_1'                      => 'string',
            'sti_apnea_2'                      => 'string',
            'sti_apnea_3'                      => 'string',
            'sti_apnea_4'                      => 'string',
            'ep_date_1'                        => 'date',
            'ep_date_2'                        => 'date',
            'ep_date_3'                        => 'date',
            'ep_date_4'                        => 'date',
            'ep_date_5'                        => 'date',
            'dset1'                            => 'string',
            'dset2'                            => 'string',
            'dset3'                            => 'string',
            'dset4'                            => 'string',
            'dset5'                            => 'string',
            'ep_e_1'                           => 'string',
            'ep_e_2'                           => 'string',
            'ep_e_3'                           => 'string',
            'ep_e_4'                           => 'string',
            'ep_e_5'                           => 'string',
            'ep_s_1'                           => 'string',
            'ep_s_2'                           => 'string',
            'ep_s_3'                           => 'string',
            'ep_s_4'                           => 'string',
            'ep_s_5'                           => 'string',
            'ep_w_1'                           => 'string',
            'ep_w_2'                           => 'string',
            'ep_w_3'                           => 'string',
            'ep_w_4'                           => 'string',
            'ep_w_5'                           => 'string',
            'ep_a_1'                           => 'string',
            'ep_a_2'                           => 'string',
            'ep_a_3'                           => 'string',
            'ep_a_4'                           => 'string',
            'ep_a_5'                           => 'string',
            'ep_el_1'                          => 'string',
            'ep_el_2'                          => 'string',
            'ep_el_3'                          => 'string',
            'ep_el_4'                          => 'string',
            'ep_el_5'                          => 'string',
            'ep_h_1'                           => 'string',
            'ep_h_2'                           => 'string',
            'ep_h_3'                           => 'string',
            'ep_h_4'                           => 'string',
            'ep_h_5'                           => 'string',
            'ep_r_1'                           => 'string',
            'ep_r_2'                           => 'string',
            'ep_r_3'                           => 'string',
            'ep_r_4'                           => 'string',
            'ep_r_5'                           => 'string',
            'mini_consult'                     => 'string',
            'exam_impressions'                 => 'string',
            'oa_soap'                          => 'string',
            'fm_blue'                          => 'string',
            'oa_check_1'                       => 'string',
            'oa_check_2'                       => 'string',
            'oa_check_3'                       => 'string',
            'oa_check_4'                       => 'string',
            'oa_check_5'                       => 'string',
            'oa_check_6'                       => 'string',
            'month_check_1'                    => 'string',
            'month_check_2'                    => 'string',
            'month_check_3'                    => 'string',
            'month_check_4'                    => 'string',
            'oa_psg'                           => 'string',
            'year_check_1'                     => 'string',
            'year_check_2'                     => 'string',
            'year_check_3'                     => 'string',
            'year_check_4'                     => 'string',
            'additional_notes'                 => 'string',
            'userid'                           => 'required|integer',
            'docid'                            => 'required|integer',
            'status'                           => 'integer',
            'office'                           => 'string',
            'sleep_same_room'                  => 'string',
            'currently_wearing'                => 'string',
            'what_percentage'                  => 'string',
            'how_long'                         => 'string',
            'sleep_md'                         => 'string',
            'test_type_name'                   => 'string',
            'sti_sleep_efficiency_1'           => 'string',
            'sti_sleep_efficiency_2'           => 'string',
            'sti_sleep_efficiency_3'           => 'string',
            'sti_sleep_efficiency_4'           => 'string',
            'sti_rem_ahi_1'                    => 'string',
            'sti_rem_ahi_2'                    => 'string',
            'sti_rem_ahi_3'                    => 'string',
            'sti_rem_ahi_4'                    => 'string',
            'sti_o2_1'                         => 'string',
            'sti_o2_2'                         => 'string',
            'sti_o2_3'                         => 'string',
            'sti_o2_4'                         => 'string',
            'sti_other_1'                      => 'string',
            'sti_other_2'                      => 'string',
            'sti_other_3'                      => 'string',
            'sti_other_4'                      => 'string',
            'ep_ts_1'                          => 'string',
            'ep_ts_2'                          => 'string',
            'ep_ts_3'                          => 'string',
            'ep_ts_4'                          => 'string',
            'ep_ts_5'                          => 'string',
            'ep_tr_1'                          => 'string',
            'ep_tr_2'                          => 'string',
            'ep_tr_3'                          => 'string',
            'ep_tr_4'                          => 'string',
            'ep_tr_5'                          => 'string',
            'appt_notes_1'                     => 'string',
            'appt_notes_2'                     => 'string',
            'appt_notes_3'                     => 'string',
            'appt_notes_4'                     => 'string',
            'appt_notes_1p3'                   => 'string',
            'appt_notes_2p3'                   => 'string',
            'appt_notes_3p3'                   => 'string',
            'appt_notes_4p3'                   => 'string',
            'appt_notes_5p3'                   => 'string',
            'wapn1'                            => 'string',
            'wapn2'                            => 'string',
            'wapn3'                            => 'string',
            'wapn4'                            => 'string',
            'wapn5'                            => 'string',
            'patientphoto'                     => ['regex:/^[a-z0-9_\-]+\.(jpg|gif|bmp|png)$/'],
            'sleep_qual1'                      => 'string',
            'sleep_qual2'                      => 'string',
            'sleep_qual3'                      => 'string',
            'sleep_qual4'                      => 'string',
            'sleep_qual5'                      => 'string',
            'location'                         => 'integer'
        ];
    }
}
