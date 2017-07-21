<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="Summary",
 *     type="object",
 *     required={"summaryid", "docpcp", "docsmd", "docomd1", "docomd2", "docdds", "osite", "cpap_totalnights", "fna", "initial_device_titration_equal_v", "dset1", "dset2", "dset3", "dset4", "dset5", "appt_notes_1", "appt_notes_2", "appt_notes_3", "appt_notes_4", "appt_notes_1p3", "appt_notes_2p3", "appt_notes_3p3", "appt_notes_4p3", "appt_notes_5p3", "wapn1", "wapn2", "wapn3", "wapn4", "wapn5", "patientphoto", "sleep_qual1", "sleep_qual2", "sleep_qual3", "sleep_qual4", "sleep_qual5"},
 *     @SWG\Property(property="summaryid", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="patient_name", type="string"),
 *     @SWG\Property(property="patient_dob", type="string"),
 *     @SWG\Property(property="docpcp", type="string"),
 *     @SWG\Property(property="docsmd", type="string"),
 *     @SWG\Property(property="docomd1", type="string"),
 *     @SWG\Property(property="docomd2", type="string"),
 *     @SWG\Property(property="docdds", type="string"),
 *     @SWG\Property(property="osite", type="string"),
 *     @SWG\Property(property="referral_source", type="string"),
 *     @SWG\Property(property="reason_seeking_tx", type="string"),
 *     @SWG\Property(property="symptoms_osa", type="string"),
 *     @SWG\Property(property="bed_time_partner", type="string"),
 *     @SWG\Property(property="snoring", type="string"),
 *     @SWG\Property(property="apnea", type="string"),
 *     @SWG\Property(property="history_surgery", type="string"),
 *     @SWG\Property(property="tried_cpap", type="string"),
 *     @SWG\Property(property="cpap_totalnights", type="integer"),
 *     @SWG\Property(property="fna", type="string"),
 *     @SWG\Property(property="cpap_date", type="string"),
 *     @SWG\Property(property="problem_cpap", type="string"),
 *     @SWG\Property(property="wearing_cpap", type="string"),
 *     @SWG\Property(property="max_translation_from", type="string"),
 *     @SWG\Property(property="max_translation_to", type="string"),
 *     @SWG\Property(property="max_translation_equal", type="string"),
 *     @SWG\Property(property="initial_device_titration_1", type="string"),
 *     @SWG\Property(property="initial_device_titration_equal_h", type="string"),
 *     @SWG\Property(property="initial_device_titration_equal_v", type="string"),
 *     @SWG\Property(property="optimum_echovision_ver", type="string"),
 *     @SWG\Property(property="optimum_echovision_hor", type="string"),
 *     @SWG\Property(property="type_device", type="string"),
 *     @SWG\Property(property="personal", type="string"),
 *     @SWG\Property(property="lab_name", type="string"),
 *     @SWG\Property(property="sti_test_1", type="string"),
 *     @SWG\Property(property="sti_test_2", type="string"),
 *     @SWG\Property(property="sti_test_3", type="string"),
 *     @SWG\Property(property="sti_test_4", type="string"),
 *     @SWG\Property(property="sti_date_1", type="string"),
 *     @SWG\Property(property="sti_date_2", type="string"),
 *     @SWG\Property(property="sti_date_3", type="string"),
 *     @SWG\Property(property="sti_date_4", type="string"),
 *     @SWG\Property(property="sti_ahi_1", type="string"),
 *     @SWG\Property(property="sti_ahi_2", type="string"),
 *     @SWG\Property(property="sti_ahi_3", type="string"),
 *     @SWG\Property(property="sti_ahi_4", type="string"),
 *     @SWG\Property(property="sti_rdi_1", type="string"),
 *     @SWG\Property(property="sti_rdi_2", type="string"),
 *     @SWG\Property(property="sti_rdi_3", type="string"),
 *     @SWG\Property(property="sti_rdi_4", type="string"),
 *     @SWG\Property(property="sti_supine_ahi_1", type="string"),
 *     @SWG\Property(property="sti_supine_ahi_2", type="string"),
 *     @SWG\Property(property="sti_supine_ahi_3", type="string"),
 *     @SWG\Property(property="sti_supine_ahi_4", type="string"),
 *     @SWG\Property(property="sti_supine_rdi_1", type="string"),
 *     @SWG\Property(property="sti_supine_rdi_2", type="string"),
 *     @SWG\Property(property="sti_supine_rdi_3", type="string"),
 *     @SWG\Property(property="sti_supine_rdi_4", type="string"),
 *     @SWG\Property(property="sti_lsat_1", type="string"),
 *     @SWG\Property(property="sti_lsat_2", type="string"),
 *     @SWG\Property(property="sti_lsat_3", type="string"),
 *     @SWG\Property(property="sti_lsat_4", type="string"),
 *     @SWG\Property(property="sti_titration_1", type="string"),
 *     @SWG\Property(property="sti_titration_2", type="string"),
 *     @SWG\Property(property="sti_titration_3", type="string"),
 *     @SWG\Property(property="sti_titration_4", type="string"),
 *     @SWG\Property(property="sti_cpap_p_1", type="string"),
 *     @SWG\Property(property="sti_cpap_p_2", type="string"),
 *     @SWG\Property(property="sti_cpap_p_3", type="string"),
 *     @SWG\Property(property="sti_cpap_p_4", type="string"),
 *     @SWG\Property(property="sti_apnea_1", type="string"),
 *     @SWG\Property(property="sti_apnea_2", type="string"),
 *     @SWG\Property(property="sti_apnea_3", type="string"),
 *     @SWG\Property(property="sti_apnea_4", type="string"),
 *     @SWG\Property(property="ep_date_1", type="string"),
 *     @SWG\Property(property="ep_date_2", type="string"),
 *     @SWG\Property(property="ep_date_3", type="string"),
 *     @SWG\Property(property="ep_date_4", type="string"),
 *     @SWG\Property(property="ep_date_5", type="string"),
 *     @SWG\Property(property="dset1", type="string"),
 *     @SWG\Property(property="dset2", type="string"),
 *     @SWG\Property(property="dset3", type="string"),
 *     @SWG\Property(property="dset4", type="string"),
 *     @SWG\Property(property="dset5", type="string"),
 *     @SWG\Property(property="ep_e_1", type="string"),
 *     @SWG\Property(property="ep_e_2", type="string"),
 *     @SWG\Property(property="ep_e_3", type="string"),
 *     @SWG\Property(property="ep_e_4", type="string"),
 *     @SWG\Property(property="ep_e_5", type="string"),
 *     @SWG\Property(property="ep_s_1", type="string"),
 *     @SWG\Property(property="ep_s_2", type="string"),
 *     @SWG\Property(property="ep_s_3", type="string"),
 *     @SWG\Property(property="ep_s_4", type="string"),
 *     @SWG\Property(property="ep_s_5", type="string"),
 *     @SWG\Property(property="ep_w_1", type="string"),
 *     @SWG\Property(property="ep_w_2", type="string"),
 *     @SWG\Property(property="ep_w_3", type="string"),
 *     @SWG\Property(property="ep_w_4", type="string"),
 *     @SWG\Property(property="ep_w_5", type="string"),
 *     @SWG\Property(property="ep_a_1", type="string"),
 *     @SWG\Property(property="ep_a_2", type="string"),
 *     @SWG\Property(property="ep_a_3", type="string"),
 *     @SWG\Property(property="ep_a_4", type="string"),
 *     @SWG\Property(property="ep_a_5", type="string"),
 *     @SWG\Property(property="ep_el_1", type="string"),
 *     @SWG\Property(property="ep_el_2", type="string"),
 *     @SWG\Property(property="ep_el_3", type="string"),
 *     @SWG\Property(property="ep_el_4", type="string"),
 *     @SWG\Property(property="ep_el_5", type="string"),
 *     @SWG\Property(property="ep_h_1", type="string"),
 *     @SWG\Property(property="ep_h_2", type="string"),
 *     @SWG\Property(property="ep_h_3", type="string"),
 *     @SWG\Property(property="ep_h_4", type="string"),
 *     @SWG\Property(property="ep_h_5", type="string"),
 *     @SWG\Property(property="ep_r_1", type="string"),
 *     @SWG\Property(property="ep_r_2", type="string"),
 *     @SWG\Property(property="ep_r_3", type="string"),
 *     @SWG\Property(property="ep_r_4", type="string"),
 *     @SWG\Property(property="ep_r_5", type="string"),
 *     @SWG\Property(property="mini_consult", type="string"),
 *     @SWG\Property(property="exam_impressions", type="string"),
 *     @SWG\Property(property="oa_soap", type="string"),
 *     @SWG\Property(property="fm_blue", type="string"),
 *     @SWG\Property(property="oa_check_1", type="string"),
 *     @SWG\Property(property="oa_check_2", type="string"),
 *     @SWG\Property(property="oa_check_3", type="string"),
 *     @SWG\Property(property="oa_check_4", type="string"),
 *     @SWG\Property(property="oa_check_5", type="string"),
 *     @SWG\Property(property="oa_check_6", type="string"),
 *     @SWG\Property(property="month_check_1", type="string"),
 *     @SWG\Property(property="month_check_2", type="string"),
 *     @SWG\Property(property="month_check_3", type="string"),
 *     @SWG\Property(property="month_check_4", type="string"),
 *     @SWG\Property(property="oa_psg", type="string"),
 *     @SWG\Property(property="year_check_1", type="string"),
 *     @SWG\Property(property="year_check_2", type="string"),
 *     @SWG\Property(property="year_check_3", type="string"),
 *     @SWG\Property(property="year_check_4", type="string"),
 *     @SWG\Property(property="additional_notes", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="office", type="string"),
 *     @SWG\Property(property="sleep_same_room", type="string"),
 *     @SWG\Property(property="currently_wearing", type="string"),
 *     @SWG\Property(property="what_percentage", type="string"),
 *     @SWG\Property(property="how_long", type="string"),
 *     @SWG\Property(property="sleep_md", type="string"),
 *     @SWG\Property(property="test_type_name", type="string"),
 *     @SWG\Property(property="sti_sleep_efficiency_1", type="string"),
 *     @SWG\Property(property="sti_sleep_efficiency_2", type="string"),
 *     @SWG\Property(property="sti_sleep_efficiency_3", type="string"),
 *     @SWG\Property(property="sti_sleep_efficiency_4", type="string"),
 *     @SWG\Property(property="sti_rem_ahi_1", type="string"),
 *     @SWG\Property(property="sti_rem_ahi_2", type="string"),
 *     @SWG\Property(property="sti_rem_ahi_3", type="string"),
 *     @SWG\Property(property="sti_rem_ahi_4", type="string"),
 *     @SWG\Property(property="sti_o2_1", type="string"),
 *     @SWG\Property(property="sti_o2_2", type="string"),
 *     @SWG\Property(property="sti_o2_3", type="string"),
 *     @SWG\Property(property="sti_o2_4", type="string"),
 *     @SWG\Property(property="sti_other_1", type="string"),
 *     @SWG\Property(property="sti_other_2", type="string"),
 *     @SWG\Property(property="sti_other_3", type="string"),
 *     @SWG\Property(property="sti_other_4", type="string"),
 *     @SWG\Property(property="ep_ts_1", type="string"),
 *     @SWG\Property(property="ep_ts_2", type="string"),
 *     @SWG\Property(property="ep_ts_3", type="string"),
 *     @SWG\Property(property="ep_ts_4", type="string"),
 *     @SWG\Property(property="ep_ts_5", type="string"),
 *     @SWG\Property(property="ep_tr_1", type="string"),
 *     @SWG\Property(property="ep_tr_2", type="string"),
 *     @SWG\Property(property="ep_tr_3", type="string"),
 *     @SWG\Property(property="ep_tr_4", type="string"),
 *     @SWG\Property(property="ep_tr_5", type="string"),
 *     @SWG\Property(property="appt_notes_1", type="string"),
 *     @SWG\Property(property="appt_notes_2", type="string"),
 *     @SWG\Property(property="appt_notes_3", type="string"),
 *     @SWG\Property(property="appt_notes_4", type="string"),
 *     @SWG\Property(property="appt_notes_1p3", type="string"),
 *     @SWG\Property(property="appt_notes_2p3", type="string"),
 *     @SWG\Property(property="appt_notes_3p3", type="string"),
 *     @SWG\Property(property="appt_notes_4p3", type="string"),
 *     @SWG\Property(property="appt_notes_5p3", type="string"),
 *     @SWG\Property(property="wapn1", type="string"),
 *     @SWG\Property(property="wapn2", type="string"),
 *     @SWG\Property(property="wapn3", type="string"),
 *     @SWG\Property(property="wapn4", type="string"),
 *     @SWG\Property(property="wapn5", type="string"),
 *     @SWG\Property(property="patientphoto", type="string"),
 *     @SWG\Property(property="sleep_qual1", type="string"),
 *     @SWG\Property(property="sleep_qual2", type="string"),
 *     @SWG\Property(property="sleep_qual3", type="string"),
 *     @SWG\Property(property="sleep_qual4", type="string"),
 *     @SWG\Property(property="sleep_qual5", type="string"),
 *     @SWG\Property(property="location", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Summary
 *
 * @property int $summaryid
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $patient_name
 * @property string|null $patient_dob
 * @property string $docpcp
 * @property string $docsmd
 * @property string $docomd1
 * @property string $docomd2
 * @property string $docdds
 * @property string $osite
 * @property string|null $referral_source
 * @property string|null $reason_seeking_tx
 * @property string|null $symptoms_osa
 * @property string|null $bed_time_partner
 * @property string|null $snoring
 * @property string|null $apnea
 * @property string|null $history_surgery
 * @property string|null $tried_cpap
 * @property int $cpap_totalnights
 * @property string $fna
 * @property string|null $cpap_date
 * @property string|null $problem_cpap
 * @property string|null $wearing_cpap
 * @property string|null $max_translation_from
 * @property string|null $max_translation_to
 * @property string|null $max_translation_equal
 * @property string|null $initial_device_titration_1
 * @property string|null $initial_device_titration_equal_h
 * @property string $initial_device_titration_equal_v
 * @property string|null $optimum_echovision_ver
 * @property string|null $optimum_echovision_hor
 * @property string|null $type_device
 * @property string|null $personal
 * @property string|null $lab_name
 * @property string|null $sti_test_1
 * @property string|null $sti_test_2
 * @property string|null $sti_test_3
 * @property string|null $sti_test_4
 * @property string|null $sti_date_1
 * @property string|null $sti_date_2
 * @property string|null $sti_date_3
 * @property string|null $sti_date_4
 * @property string|null $sti_ahi_1
 * @property string|null $sti_ahi_2
 * @property string|null $sti_ahi_3
 * @property string|null $sti_ahi_4
 * @property string|null $sti_rdi_1
 * @property string|null $sti_rdi_2
 * @property string|null $sti_rdi_3
 * @property string|null $sti_rdi_4
 * @property string|null $sti_supine_ahi_1
 * @property string|null $sti_supine_ahi_2
 * @property string|null $sti_supine_ahi_3
 * @property string|null $sti_supine_ahi_4
 * @property string|null $sti_supine_rdi_1
 * @property string|null $sti_supine_rdi_2
 * @property string|null $sti_supine_rdi_3
 * @property string|null $sti_supine_rdi_4
 * @property string|null $sti_lsat_1
 * @property string|null $sti_lsat_2
 * @property string|null $sti_lsat_3
 * @property string|null $sti_lsat_4
 * @property string|null $sti_titration_1
 * @property string|null $sti_titration_2
 * @property string|null $sti_titration_3
 * @property string|null $sti_titration_4
 * @property string|null $sti_cpap_p_1
 * @property string|null $sti_cpap_p_2
 * @property string|null $sti_cpap_p_3
 * @property string|null $sti_cpap_p_4
 * @property string|null $sti_apnea_1
 * @property string|null $sti_apnea_2
 * @property string|null $sti_apnea_3
 * @property string|null $sti_apnea_4
 * @property string|null $ep_date_1
 * @property string|null $ep_date_2
 * @property string|null $ep_date_3
 * @property string|null $ep_date_4
 * @property string|null $ep_date_5
 * @property string $dset1
 * @property string $dset2
 * @property string $dset3
 * @property string $dset4
 * @property string $dset5
 * @property string|null $ep_e_1
 * @property string|null $ep_e_2
 * @property string|null $ep_e_3
 * @property string|null $ep_e_4
 * @property string|null $ep_e_5
 * @property string|null $ep_s_1
 * @property string|null $ep_s_2
 * @property string|null $ep_s_3
 * @property string|null $ep_s_4
 * @property string|null $ep_s_5
 * @property string|null $ep_w_1
 * @property string|null $ep_w_2
 * @property string|null $ep_w_3
 * @property string|null $ep_w_4
 * @property string|null $ep_w_5
 * @property string|null $ep_a_1
 * @property string|null $ep_a_2
 * @property string|null $ep_a_3
 * @property string|null $ep_a_4
 * @property string|null $ep_a_5
 * @property string|null $ep_el_1
 * @property string|null $ep_el_2
 * @property string|null $ep_el_3
 * @property string|null $ep_el_4
 * @property string|null $ep_el_5
 * @property string|null $ep_h_1
 * @property string|null $ep_h_2
 * @property string|null $ep_h_3
 * @property string|null $ep_h_4
 * @property string|null $ep_h_5
 * @property string|null $ep_r_1
 * @property string|null $ep_r_2
 * @property string|null $ep_r_3
 * @property string|null $ep_r_4
 * @property string|null $ep_r_5
 * @property string|null $mini_consult
 * @property string|null $exam_impressions
 * @property string|null $oa_soap
 * @property string|null $fm_blue
 * @property string|null $oa_check_1
 * @property string|null $oa_check_2
 * @property string|null $oa_check_3
 * @property string|null $oa_check_4
 * @property string|null $oa_check_5
 * @property string|null $oa_check_6
 * @property string|null $month_check_1
 * @property string|null $month_check_2
 * @property string|null $month_check_3
 * @property string|null $month_check_4
 * @property string|null $oa_psg
 * @property string|null $year_check_1
 * @property string|null $year_check_2
 * @property string|null $year_check_3
 * @property string|null $year_check_4
 * @property string|null $additional_notes
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $office
 * @property string|null $sleep_same_room
 * @property string|null $currently_wearing
 * @property string|null $what_percentage
 * @property string|null $how_long
 * @property string|null $sleep_md
 * @property string|null $test_type_name
 * @property string|null $sti_sleep_efficiency_1
 * @property string|null $sti_sleep_efficiency_2
 * @property string|null $sti_sleep_efficiency_3
 * @property string|null $sti_sleep_efficiency_4
 * @property string|null $sti_rem_ahi_1
 * @property string|null $sti_rem_ahi_2
 * @property string|null $sti_rem_ahi_3
 * @property string|null $sti_rem_ahi_4
 * @property string|null $sti_o2_1
 * @property string|null $sti_o2_2
 * @property string|null $sti_o2_3
 * @property string|null $sti_o2_4
 * @property string|null $sti_other_1
 * @property string|null $sti_other_2
 * @property string|null $sti_other_3
 * @property string|null $sti_other_4
 * @property string|null $ep_ts_1
 * @property string|null $ep_ts_2
 * @property string|null $ep_ts_3
 * @property string|null $ep_ts_4
 * @property string|null $ep_ts_5
 * @property string|null $ep_tr_1
 * @property string|null $ep_tr_2
 * @property string|null $ep_tr_3
 * @property string|null $ep_tr_4
 * @property string|null $ep_tr_5
 * @property string $appt_notes_1
 * @property string $appt_notes_2
 * @property string $appt_notes_3
 * @property string $appt_notes_4
 * @property string $appt_notes_1p3
 * @property string $appt_notes_2p3
 * @property string $appt_notes_3p3
 * @property string $appt_notes_4p3
 * @property string $appt_notes_5p3
 * @property string $wapn1
 * @property string $wapn2
 * @property string $wapn3
 * @property string $wapn4
 * @property string $wapn5
 * @property string $patientphoto
 * @property string $sleep_qual1
 * @property string $sleep_qual2
 * @property string $sleep_qual3
 * @property string $sleep_qual4
 * @property string $sleep_qual5
 * @property int|null $location
 * @mixin \Eloquent
 */
class Summary extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['summaryid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_summary';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'summaryid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    /**
     * @param array $fields
     * @param array $where
     * @return Summary[]
     */
    public function getWithFilter($fields = [], $where = [])
    {
        $object = $this;

        if (count($fields)) {
            $object = $object->select($fields);
        }

        if (count($where)) {
            foreach ($where as $key => $value) {
                $object = $object->where($key, $value);
            }
        }

        return $object->get();
    }
}
