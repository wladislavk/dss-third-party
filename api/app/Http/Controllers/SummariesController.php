<?php

namespace DentalSleepSolutions\Http\Controllers;

/**
 * @todo: restore API tests if needed or delete the controller
 */
class SummariesController extends BaseRestController
{
    /** @var string */
    protected $ipAddressKey = 'ip_address';

    /** @var string */
    protected $patientKey = 'patientid';

    /** @var string */
    protected $doctorKey = 'docid';

    /** @var string */
    protected $userKey = 'userid';

    /** @var string */
    protected $filterByPatientKey = 'patientid';

    /**
     * @SWG\Get(
     *     path="/summaries",
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
     *                         @SWG\Items(ref="#/definitions/Summary")
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
     *     path="/summaries/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Summary")
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
     *     path="/summaries",
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patient_name", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_dob", in="formData", type="string"),
     *     @SWG\Parameter(name="docpcp", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="docsmd", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="docomd1", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="docomd2", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="docdds", in="formData", type="string"),
     *     @SWG\Parameter(name="osite", in="formData", type="string"),
     *     @SWG\Parameter(name="referral_source", in="formData", type="string"),
     *     @SWG\Parameter(name="reason_seeking_tx", in="formData", type="string"),
     *     @SWG\Parameter(name="symptoms_osa", in="formData", type="string"),
     *     @SWG\Parameter(name="bed_time_partner", in="formData", type="string"),
     *     @SWG\Parameter(name="snoring", in="formData", type="string"),
     *     @SWG\Parameter(name="apnea", in="formData", type="string"),
     *     @SWG\Parameter(name="history_surgery", in="formData", type="string"),
     *     @SWG\Parameter(name="tried_cpap", in="formData", type="string"),
     *     @SWG\Parameter(name="cpap_totalnights", in="formData", type="integer"),
     *     @SWG\Parameter(name="fna", in="formData", type="string"),
     *     @SWG\Parameter(name="cpap_date", in="formData", type="string"),
     *     @SWG\Parameter(name="problem_cpap", in="formData", type="string"),
     *     @SWG\Parameter(name="wearing_cpap", in="formData", type="string"),
     *     @SWG\Parameter(name="max_translation_from", in="formData", type="string"),
     *     @SWG\Parameter(name="max_translation_to", in="formData", type="string"),
     *     @SWG\Parameter(name="max_translation_equal", in="formData", type="string"),
     *     @SWG\Parameter(name="initial_device_titration_1", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="initial_device_titration_equal_h", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="initial_device_titration_equal_v", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="optimum_echovision_ver", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="optimum_echovision_hor", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="type_device", in="formData", type="string"),
     *     @SWG\Parameter(name="personal", in="formData", type="string"),
     *     @SWG\Parameter(name="lab_name", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_test_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_test_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_test_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_test_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_date_1", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="sti_date_2", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="sti_date_3", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="sti_date_4", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="sti_ahi_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_ahi_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_ahi_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_ahi_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rdi_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rdi_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rdi_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rdi_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_ahi_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_ahi_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_ahi_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_ahi_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_rdi_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_rdi_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_rdi_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_rdi_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_lsat_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_lsat_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_lsat_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_lsat_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_titration_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_titration_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_titration_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_titration_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_cpap_p_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_cpap_p_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_cpap_p_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_cpap_p_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_apnea_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_apnea_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_apnea_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_apnea_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_date_1", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ep_date_2", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ep_date_3", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ep_date_4", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ep_date_5", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="dset1", in="formData", type="string"),
     *     @SWG\Parameter(name="dset2", in="formData", type="string"),
     *     @SWG\Parameter(name="dset3", in="formData", type="string"),
     *     @SWG\Parameter(name="dset4", in="formData", type="string"),
     *     @SWG\Parameter(name="dset5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_e_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_e_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_e_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_e_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_e_5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_s_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_s_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_s_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_s_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_s_5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_w_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_w_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_w_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_w_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_w_5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_a_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_a_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_a_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_a_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_a_5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_el_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_el_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_el_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_el_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_el_5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_h_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_h_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_h_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_h_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_h_5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_r_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_r_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_r_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_r_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_r_5", in="formData", type="string"),
     *     @SWG\Parameter(name="mini_consult", in="formData", type="string"),
     *     @SWG\Parameter(name="exam_impressions", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_soap", in="formData", type="string"),
     *     @SWG\Parameter(name="fm_blue", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_check_1", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_check_2", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_check_3", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_check_4", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_check_5", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_check_6", in="formData", type="string"),
     *     @SWG\Parameter(name="month_check_1", in="formData", type="string"),
     *     @SWG\Parameter(name="month_check_2", in="formData", type="string"),
     *     @SWG\Parameter(name="month_check_3", in="formData", type="string"),
     *     @SWG\Parameter(name="month_check_4", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_psg", in="formData", type="string"),
     *     @SWG\Parameter(name="year_check_1", in="formData", type="string"),
     *     @SWG\Parameter(name="year_check_2", in="formData", type="string"),
     *     @SWG\Parameter(name="year_check_3", in="formData", type="string"),
     *     @SWG\Parameter(name="year_check_4", in="formData", type="string"),
     *     @SWG\Parameter(name="additional_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="office", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_same_room", in="formData", type="string"),
     *     @SWG\Parameter(name="currently_wearing", in="formData", type="string"),
     *     @SWG\Parameter(name="what_percentage", in="formData", type="string"),
     *     @SWG\Parameter(name="how_long", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_md", in="formData", type="string"),
     *     @SWG\Parameter(name="test_type_name", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_sleep_efficiency_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_sleep_efficiency_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_sleep_efficiency_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_sleep_efficiency_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rem_ahi_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rem_ahi_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rem_ahi_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rem_ahi_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_o2_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_o2_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_o2_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_o2_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_other_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_other_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_other_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_other_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_ts_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_ts_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_ts_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_ts_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_ts_5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_tr_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_tr_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_tr_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_tr_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_tr_5", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_1", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_2", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_3", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_4", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_1p3", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_2p3", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_3p3", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_4p3", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_5p3", in="formData", type="string"),
     *     @SWG\Parameter(name="wapn1", in="formData", type="string"),
     *     @SWG\Parameter(name="wapn2", in="formData", type="string"),
     *     @SWG\Parameter(name="wapn3", in="formData", type="string"),
     *     @SWG\Parameter(name="wapn4", in="formData", type="string"),
     *     @SWG\Parameter(name="wapn5", in="formData", type="string"),
     *     @SWG\Parameter(name="patientphoto", in="formData", type="string", pattern="^[a-z0-9_\-]+\.(jpg|gif|bmp|png)$"),
     *     @SWG\Parameter(name="sleep_qual1", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_qual2", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_qual3", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_qual4", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_qual5", in="formData", type="string"),
     *     @SWG\Parameter(name="location", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Summary")
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
     *     path="/summaries/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patient_name", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_dob", in="formData", type="string"),
     *     @SWG\Parameter(name="docpcp", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="docsmd", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="docomd1", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="docomd2", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="docdds", in="formData", type="string"),
     *     @SWG\Parameter(name="osite", in="formData", type="string"),
     *     @SWG\Parameter(name="referral_source", in="formData", type="string"),
     *     @SWG\Parameter(name="reason_seeking_tx", in="formData", type="string"),
     *     @SWG\Parameter(name="symptoms_osa", in="formData", type="string"),
     *     @SWG\Parameter(name="bed_time_partner", in="formData", type="string"),
     *     @SWG\Parameter(name="snoring", in="formData", type="string"),
     *     @SWG\Parameter(name="apnea", in="formData", type="string"),
     *     @SWG\Parameter(name="history_surgery", in="formData", type="string"),
     *     @SWG\Parameter(name="tried_cpap", in="formData", type="string"),
     *     @SWG\Parameter(name="cpap_totalnights", in="formData", type="integer"),
     *     @SWG\Parameter(name="fna", in="formData", type="string"),
     *     @SWG\Parameter(name="cpap_date", in="formData", type="string"),
     *     @SWG\Parameter(name="problem_cpap", in="formData", type="string"),
     *     @SWG\Parameter(name="wearing_cpap", in="formData", type="string"),
     *     @SWG\Parameter(name="max_translation_from", in="formData", type="string"),
     *     @SWG\Parameter(name="max_translation_to", in="formData", type="string"),
     *     @SWG\Parameter(name="max_translation_equal", in="formData", type="string"),
     *     @SWG\Parameter(name="initial_device_titration_1", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="initial_device_titration_equal_h", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="initial_device_titration_equal_v", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="optimum_echovision_ver", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="optimum_echovision_hor", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="type_device", in="formData", type="string"),
     *     @SWG\Parameter(name="personal", in="formData", type="string"),
     *     @SWG\Parameter(name="lab_name", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_test_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_test_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_test_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_test_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_date_1", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="sti_date_2", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="sti_date_3", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="sti_date_4", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="sti_ahi_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_ahi_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_ahi_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_ahi_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rdi_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rdi_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rdi_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rdi_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_ahi_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_ahi_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_ahi_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_ahi_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_rdi_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_rdi_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_rdi_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_supine_rdi_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_lsat_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_lsat_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_lsat_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_lsat_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_titration_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_titration_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_titration_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_titration_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_cpap_p_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_cpap_p_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_cpap_p_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_cpap_p_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_apnea_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_apnea_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_apnea_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_apnea_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_date_1", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ep_date_2", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ep_date_3", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ep_date_4", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ep_date_5", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="dset1", in="formData", type="string"),
     *     @SWG\Parameter(name="dset2", in="formData", type="string"),
     *     @SWG\Parameter(name="dset3", in="formData", type="string"),
     *     @SWG\Parameter(name="dset4", in="formData", type="string"),
     *     @SWG\Parameter(name="dset5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_e_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_e_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_e_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_e_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_e_5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_s_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_s_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_s_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_s_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_s_5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_w_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_w_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_w_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_w_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_w_5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_a_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_a_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_a_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_a_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_a_5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_el_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_el_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_el_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_el_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_el_5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_h_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_h_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_h_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_h_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_h_5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_r_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_r_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_r_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_r_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_r_5", in="formData", type="string"),
     *     @SWG\Parameter(name="mini_consult", in="formData", type="string"),
     *     @SWG\Parameter(name="exam_impressions", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_soap", in="formData", type="string"),
     *     @SWG\Parameter(name="fm_blue", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_check_1", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_check_2", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_check_3", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_check_4", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_check_5", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_check_6", in="formData", type="string"),
     *     @SWG\Parameter(name="month_check_1", in="formData", type="string"),
     *     @SWG\Parameter(name="month_check_2", in="formData", type="string"),
     *     @SWG\Parameter(name="month_check_3", in="formData", type="string"),
     *     @SWG\Parameter(name="month_check_4", in="formData", type="string"),
     *     @SWG\Parameter(name="oa_psg", in="formData", type="string"),
     *     @SWG\Parameter(name="year_check_1", in="formData", type="string"),
     *     @SWG\Parameter(name="year_check_2", in="formData", type="string"),
     *     @SWG\Parameter(name="year_check_3", in="formData", type="string"),
     *     @SWG\Parameter(name="year_check_4", in="formData", type="string"),
     *     @SWG\Parameter(name="additional_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="office", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_same_room", in="formData", type="string"),
     *     @SWG\Parameter(name="currently_wearing", in="formData", type="string"),
     *     @SWG\Parameter(name="what_percentage", in="formData", type="string"),
     *     @SWG\Parameter(name="how_long", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_md", in="formData", type="string"),
     *     @SWG\Parameter(name="test_type_name", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_sleep_efficiency_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_sleep_efficiency_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_sleep_efficiency_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_sleep_efficiency_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rem_ahi_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rem_ahi_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rem_ahi_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_rem_ahi_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_o2_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_o2_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_o2_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_o2_4", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_other_1", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_other_2", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_other_3", in="formData", type="string"),
     *     @SWG\Parameter(name="sti_other_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_ts_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_ts_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_ts_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_ts_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_ts_5", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_tr_1", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_tr_2", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_tr_3", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_tr_4", in="formData", type="string"),
     *     @SWG\Parameter(name="ep_tr_5", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_1", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_2", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_3", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_4", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_1p3", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_2p3", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_3p3", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_4p3", in="formData", type="string"),
     *     @SWG\Parameter(name="appt_notes_5p3", in="formData", type="string"),
     *     @SWG\Parameter(name="wapn1", in="formData", type="string"),
     *     @SWG\Parameter(name="wapn2", in="formData", type="string"),
     *     @SWG\Parameter(name="wapn3", in="formData", type="string"),
     *     @SWG\Parameter(name="wapn4", in="formData", type="string"),
     *     @SWG\Parameter(name="wapn5", in="formData", type="string"),
     *     @SWG\Parameter(name="patientphoto", in="formData", type="string", pattern="^[a-z0-9_\-]+\.(jpg|gif|bmp|png)$"),
     *     @SWG\Parameter(name="sleep_qual1", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_qual2", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_qual3", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_qual4", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_qual5", in="formData", type="string"),
     *     @SWG\Parameter(name="location", in="formData", type="integer"),
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
     *     path="/summaries/{id}",
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
     * @SWG\Get(
     *     path="/summaries/latest",
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Summary")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function latest()
    {
        return parent::latest();
    }
}
