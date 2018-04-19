<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet;
use Tests\TestCases\ApiTestCase;

class NewFlowsheetsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return NewFlowsheet::class;
    }

    protected function getRoute()
    {
        return '/new-flowsheets';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 100,
            "patientid" => 8,
            "inquiry_call_comp" => "03/27/1982",
            "send_np" => "est",
            "send_np_comp" => "quod",
            "acquire_ss_apt" => "aut",
            "acquire_ss_comp" => "10/30/1986",
            "pt_not_ss" => "eum",
            "ss_date_requested" => "facere",
            "ss_date_received" => "ex",
            "date_referred" => "12/10/2007",
            "dss_dentists" => "delectus",
            "ss_requested_apt" => "08/20/1984",
            "ss_requested_comp" => "06/02/1994",
            "ss_received_apt" => "12/22/1999",
            "ss_received_comp" => "07/14/2010",
            "consultation_apt" => "08/13/1990",
            "consultation_comp" => "omnis",
            "m_insurance_date" => "02/13/1973",
            "select_type" => "velit",
            "exam_impressions_apt" => "reiciendis",
            "exam_impressions_comp" => "beatae",
            "dsr_prepared" => "possimus",
            "dsr_sent" => "commodi",
            "delivery_device_apt" => "ut",
            "delivery_device_comp" => "expedita",
            "dsr_date_delivered" => "laudantium",
            "ltr_phy_prepared" => "debitis",
            "ltr_phy_sent" => "et",
            "first_check_apt" => "in",
            "first_check_comp" => "architecto",
            "add_check_apt" => "voluptatibus",
            "add_check_comp" => "et",
            "home_sleep_apt" => "perferendis",
            "home_sleep_comp" => "dolores",
            "further_checks_apt" => "laboriosam",
            "further_checks_comp" => "ex",
            "comp_treatment_date" => "maxime",
            "portable_date_comp" => "est",
            "treatment_success" => "laboriosam",
            "ltr_doc_ss_date_prepared" => "aut",
            "ltr_doc_ss_date_sent" => "ratione",
            "annual_exam_apt" => "ad",
            "annual_exam_comp" => "pariatur",
            "ltr_doc_pt_date_prepared" => "a",
            "ltr_doc_pt_date_sent" => "occaecati",
            "ambulatory_ss_apt" => "08/12/1971",
            "ambulatory_ss_comp" => "06/11/1976",
            "diag_s_md_sent" => "03/15/2015",
            "diag_s_md_received" => "06/12/1986",
            "psg_apt" => "11/01/1992",
            "psg_comp" => "consequuntur",
            "sleep_lab" => "nam",
            "lomn" => "fuga",
            "rxfrommd" => "explicabo",
            "not_candidate" => "rerum",
            "financial_restraints" => "cum",
            "pt_needing_dental_work" => "odio",
            "inadequate_dentition" => "quia",
            "pt_not_ds_other" => "aut",
            "ltr_pp_date_prepared" => "10/03/2007",
            "ltr_pp_date_sent" => "et",
            "userid" => 1,
            "docid" => 9,
            "status" => 9,
            "step" => 0,
            "sstep" => 7,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'patientid' => 100,
            'userid'    => 200,
        ];
    }
}
