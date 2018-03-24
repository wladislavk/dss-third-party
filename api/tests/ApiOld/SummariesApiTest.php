<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Summary;
use Tests\TestCases\ApiTestCase;

class SummariesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Summary::class;
    }

    protected function getRoute()
    {
        return '/summaries';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 100,
            "patientid" => 2,
            "patient_name" => "Isabel Ortiz",
            "patient_dob" => "02/16/1976",
            "docpcp" => "38",
            "docsmd" => "69",
            "docomd1" => "45",
            "docomd2" => "98",
            "docdds" => "consequuntur",
            "osite" => "aliquam",
            "referral_source" => "et",
            "reason_seeking_tx" => "quas",
            "symptoms_osa" => "maiores",
            "bed_time_partner" => "omnis",
            "snoring" => "animi",
            "apnea" => "quis",
            "history_surgery" => "error",
            "tried_cpap" => "ducimus",
            "cpap_totalnights" => 0,
            "fna" => "voluptate",
            "cpap_date" => "blanditiis",
            "problem_cpap" => "dignissimos",
            "wearing_cpap" => "accusamus",
            "max_translation_from" => "omnis",
            "max_translation_to" => "nihil",
            "max_translation_equal" => "quia",
            "initial_device_titration_1" => "49",
            "initial_device_titration_equal_h" => "06",
            "initial_device_titration_equal_v" => "46",
            "optimum_echovision_ver" => "62",
            "optimum_echovision_hor" => "33",
            "type_device" => "itaque",
            "personal" => "ab",
            "lab_name" => "vero",
            "sti_test_1" => "cum",
            "sti_test_2" => "animi",
            "sti_test_3" => "corporis",
            "sti_test_4" => "soluta",
            "sti_date_1" => "2012-11-18",
            "sti_date_2" => "1992-12-21",
            "sti_date_3" => "2017-02-21",
            "sti_date_4" => "1970-03-24",
            "sti_ahi_1" => "iure",
            "sti_ahi_2" => "delectus",
            "sti_ahi_3" => "numquam",
            "sti_ahi_4" => "ab",
            "sti_rdi_1" => "odio",
            "sti_rdi_2" => "voluptatibus",
            "sti_rdi_3" => "laudantium",
            "sti_rdi_4" => "velit",
            "sti_supine_ahi_1" => "consectetur",
            "sti_supine_ahi_2" => "reiciendis",
            "sti_supine_ahi_3" => "laboriosam",
            "sti_supine_ahi_4" => "iste",
            "sti_supine_rdi_1" => "quidem",
            "sti_supine_rdi_2" => "consequuntur",
            "sti_supine_rdi_3" => "itaque",
            "sti_supine_rdi_4" => "in",
            "sti_lsat_1" => "qui",
            "sti_lsat_2" => "voluptatem",
            "sti_lsat_3" => "et",
            "sti_lsat_4" => "ratione",
            "sti_titration_1" => "et",
            "sti_titration_2" => "accusamus",
            "sti_titration_3" => "ducimus",
            "sti_titration_4" => "et",
            "sti_cpap_p_1" => "nihil",
            "sti_cpap_p_2" => "aut",
            "sti_cpap_p_3" => "labore",
            "sti_cpap_p_4" => "officia",
            "sti_apnea_1" => "eum",
            "sti_apnea_2" => "non",
            "sti_apnea_3" => "dicta",
            "sti_apnea_4" => "sint",
            "ep_date_1" => "2015-06-24",
            "ep_date_2" => "1990-09-22",
            "ep_date_3" => "1996-09-03",
            "ep_date_4" => "2001-05-26",
            "ep_date_5" => "2004-03-30",
            "dset1" => "ipsa",
            "dset2" => "dolorem",
            "dset3" => "reprehenderit",
            "dset4" => "quia",
            "dset5" => "sed",
            "ep_e_1" => "nesciunt",
            "ep_e_2" => "aut",
            "ep_e_3" => "velit",
            "ep_e_4" => "quae",
            "ep_e_5" => "deserunt",
            "ep_s_1" => "facilis",
            "ep_s_2" => "sit",
            "ep_s_3" => "enim",
            "ep_s_4" => "ut",
            "ep_s_5" => "vitae",
            "ep_w_1" => "necessitatibus",
            "ep_w_2" => "eligendi",
            "ep_w_3" => "tempore",
            "ep_w_4" => "doloremque",
            "ep_w_5" => "beatae",
            "ep_a_1" => "molestias",
            "ep_a_2" => "vero",
            "ep_a_3" => "ea",
            "ep_a_4" => "qui",
            "ep_a_5" => "aspernatur",
            "ep_el_1" => "omnis",
            "ep_el_2" => "ut",
            "ep_el_3" => "ipsam",
            "ep_el_4" => "ipsa",
            "ep_el_5" => "nihil",
            "ep_h_1" => "rem",
            "ep_h_2" => "rerum",
            "ep_h_3" => "cumque",
            "ep_h_4" => "aspernatur",
            "ep_h_5" => "qui",
            "ep_r_1" => "ea",
            "ep_r_2" => "quibusdam",
            "ep_r_3" => "est",
            "ep_r_4" => "non",
            "ep_r_5" => "unde",
            "mini_consult" => "est",
            "exam_impressions" => "assumenda",
            "oa_soap" => "facilis",
            "fm_blue" => "laboriosam",
            "oa_check_1" => "sit",
            "oa_check_2" => "dicta",
            "oa_check_3" => "sit",
            "oa_check_4" => "consequatur",
            "oa_check_5" => "quod",
            "oa_check_6" => "vitae",
            "month_check_1" => "rerum",
            "month_check_2" => "consequatur",
            "month_check_3" => "sed",
            "month_check_4" => "sequi",
            "oa_psg" => "delectus",
            "year_check_1" => "quam",
            "year_check_2" => "similique",
            "year_check_3" => "facere",
            "year_check_4" => "laboriosam",
            "additional_notes" => "Aut hic quasi ullam asperiores autem.",
            "userid" => 7,
            "docid" => 8,
            "status" => 3,
            "office" => "labore",
            "sleep_same_room" => "voluptatibus",
            "currently_wearing" => "voluptates",
            "what_percentage" => "quis",
            "how_long" => "placeat",
            "sleep_md" => "sed",
            "test_type_name" => "ex",
            "sti_sleep_efficiency_1" => "corporis",
            "sti_sleep_efficiency_2" => "consequatur",
            "sti_sleep_efficiency_3" => "labore",
            "sti_sleep_efficiency_4" => "qui",
            "sti_rem_ahi_1" => "officia",
            "sti_rem_ahi_2" => "nihil",
            "sti_rem_ahi_3" => "ad",
            "sti_rem_ahi_4" => "molestiae",
            "sti_o2_1" => "aut",
            "sti_o2_2" => "voluptas",
            "sti_o2_3" => "nam",
            "sti_o2_4" => "quos",
            "sti_other_1" => "tempora",
            "sti_other_2" => "nihil",
            "sti_other_3" => "soluta",
            "sti_other_4" => "incidunt",
            "ep_ts_1" => "voluptatibus",
            "ep_ts_2" => "assumenda",
            "ep_ts_3" => "et",
            "ep_ts_4" => "sint",
            "ep_ts_5" => "assumenda",
            "ep_tr_1" => "repudiandae",
            "ep_tr_2" => "molestiae",
            "ep_tr_3" => "deserunt",
            "ep_tr_4" => "nihil",
            "ep_tr_5" => "officia",
            "appt_notes_1" => "voluptatum",
            "appt_notes_2" => "repellendus",
            "appt_notes_3" => "alias",
            "appt_notes_4" => "sit",
            "appt_notes_1p3" => "sequi",
            "appt_notes_2p3" => "voluptatibus",
            "appt_notes_3p3" => "ut",
            "appt_notes_4p3" => "magnam",
            "appt_notes_5p3" => "dolores",
            "wapn1" => "et",
            "wapn2" => "accusantium",
            "wapn3" => "quod",
            "wapn4" => "nisi",
            "wapn5" => "architecto",
            "patientphoto" => "hbj.gif",
            "sleep_qual1" => "quaerat",
            "sleep_qual2" => "eaque",
            "sleep_qual3" => "dolorem",
            "sleep_qual4" => "sit",
            "sleep_qual5" => "nisi",
            "location" => 8,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'patientid'    => 123,
            'patient_name' => 'John Doe',
        ];
    }
}
