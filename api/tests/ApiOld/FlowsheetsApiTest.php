<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet;
use Tests\TestCases\ApiTestCase;

class FlowsheetsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Flowsheet::class;
    }

    protected function getRoute()
    {
        return '/flowsheets';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 3,
            "patientid" => 0,
            "inquiry_call_apt" => "07/09/1970",
            "inquiry_call_comp" => "02/12/1997",
            "send_np" => "nulla",
            "send_np_comp" => "10/12/2011",
            "acquire_ss_apt" => "02/23/2007",
            "acquire_ss_comp" => "10/11/1989",
            "referral_dss_apt" => "04/01/2009",
            "referral_dss_comp" => "10/21/2012",
            "ss_requested_apt" => "et",
            "ss_requested_comp" => "nemo",
            "ss_received_apt" => "rerum",
            "ss_received_comp" => "voluptatem",
            "consultation_apt" => "08/30/1980",
            "consultation_comp" => "aspernatur",
            "m_insurance_apt" => "09/02/1989",
            "m_insurance_comp" => "10/09/1986",
            "select_type" => "Eaque numquam error.",
            "exam_impressions_apt" => "09/20/1985",
            "exam_impressions_comp" => "ex",
            "ltr_physicians_apt" => "ea",
            "ltr_physicians_comp" => "itaque",
            "ltr_marketing_apt" => "non",
            "ltr_marketing_comp" => "non",
            "delivery_device_apt" => "doloribus",
            "delivery_device_comp" => "quia",
            "ltr_marketing_pt_apt" => "dolor",
            "ltr_marketing_pt_comp" => "nemo",
            "ltr_corr_phy_apt" => "voluptatem",
            "ltr_corr_phy_comp" => "eius",
            "first_check_apt" => "commodi",
            "first_check_comp" => "dolore",
            "add_check_apt" => "enim",
            "add_check_comp" => "nobis",
            "home_sleep_apt" => "quo",
            "home_sleep_comp" => "odit",
            "further_checks_apt" => "voluptates",
            "further_checks_comp" => "quis",
            "comp_treatment_apt" => "enim",
            "comp_treatment_comp" => "consequatur",
            "ltr_copy_ss_apt" => "aut",
            "ltr_copy_ss_comp" => "quo",
            "annual_exam_apt" => "quidem",
            "annual_exam_comp" => "deleniti",
            "pos_home_sleep_apt" => "consequatur",
            "pos_home_sleep_comp" => "est",
            "ltr_corr_phy1_apt" => "cupiditate",
            "ltr_corr_phy1_comp" => "a",
            "ambulatory_ss_apt" => "11/24/1977",
            "ambulatory_ss_comp" => "12/20/1972",
            "diag_s_md_apt" => "magnam",
            "diag_s_md_comp" => "minus",
            "psg_apt" => "deleniti",
            "psg_comp" => "aut",
            "pt_not_ds_apt" => "aut",
            "pt_not_ds_comp" => "earum",
            "not_candidate_apt" => "accusamus",
            "not_candidate_comp" => "placeat",
            "fin_restraints_apt" => "et",
            "fin_restraints_comp" => "non",
            "pt_needing_apt" => "fugiat",
            "pt_needing_comp" => "sit",
            "inadequate_apt" => "praesentium",
            "inadequate_comp" => "commodi",
            "userid" => 100,
            "docid" => 5,
            "status" => 3,
            "step" => 3,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'select_type' => 'updated select type',
            'userid'      => 7,
        ];
    }
}
