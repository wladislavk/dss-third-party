<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Insurance;
use Tests\TestCases\ApiTestCase;

class InsurancesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Insurance::class;
    }

    protected function getRoute()
    {
        return '/insurances';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 7,
            "patientid" => 8,
            "pica1" => "eos",
            "pica2" => "unde",
            "pica3" => "quo",
            "insurance_type" => "7",
            "insured_id_number" => "085175",
            "patient_firstname" => "Rogers",
            "patient_lastname" => "Rolfson",
            "patient_middle" => "T",
            "patient_dob" => "2017-07-24",
            "patient_sex" => "M",
            "insured_firstname" => "Javonte",
            "insured_lastname" => "Brown",
            "insured_middle" => "N",
            "patient_address" => "94006 Aufderhar Stravenue\nHudsonfurt, ID 34517",
            "patient_relation_insured" => "Self",
            "insured_address" => "91705 Albertha Rapid Suite 195\nBoyerland, IN 48794",
            "patient_city" => "Hoegermouth",
            "patient_state" => "NJ",
            "patient_status" => "~BkKnWDm~",
            "insured_city" => "New Leda",
            "insured_state" => "OK",
            "patient_zip" => "71680",
            "patient_phone_code" => "088",
            "patient_phone" => "0503343351",
            "insured_zip" => "34040",
            "insured_phone_code" => "839",
            "insured_phone" => "4311736115",
            "insured_policy_group_feca" => "471948",
            "insured_dob" => "2017-07-24",
            "insured_sex" => "F",
            "insured_employer_school_name" => "Pariatur delectus sed rem.",
            "insured_insurance_plan" => "Eaque aut aut.",
            "other_insured_insurance_plan" => "Eos incidunt.",
            "another_plan" => "YES",
            "patient_signature" => "quos",
            "patient_signed_date" => "2017-07-24",
            "insured_signature" => "autem",
            "diagnosis_1" => "repellat",
            "diagnosis_2" => "omnis",
            "diagnosis_3" => "libero",
            "diagnosis_4" => "sequi",
            "service_date1_from" => "2017-07-24",
            "service_date1_to" => "2017-07-24",
            "place_of_service1" => "aut",
            "cpt_hcpcs1" => "M3950",
            "s_charges1_1" => "685.98",
            "s_charges1_2" => "974.02",
            "federal_tax_id_number" => "3676",
            "ein" => "5",
            "accept_assignment" => "A",
            "total_charge" => 733.04,
            "amount_paid" => "99283.98",
            "balance_due" => "62.62",
            "signature_physician" => "Y",
            "physician_signed_date" => "2017-07-24",
            "service_facility_info_name" => "Eloy Stiedemann MD",
            "service_facility_info_address" => "75810 Sadye Center Apt. 103\nEast Jenifer, VA 64431-9633",
            "service_facility_info_city" => "Adonisborough",
            "service_info_a" => "Vel optio eius occaecati in.",
            "billing_provider_phone_code" => "374",
            "billing_provider_phone" => "0704190770",
            "billing_provider_name" => "Ms. Ettie Mosciski",
            "billing_provider_address" => "2990 Mann Cape Apt. 113\nWest Olinhaven, IA 67892-0195",
            "billing_provider_city" => "Hoegerfort",
            "billing_provider_a" => "Et accusantium odit et.",
            "userid" => 100,
            "docid" => 9,
            "status" => 4,
            "card" => 0,
            "dispute_reason" => "Nulla qui fugiat dignissimos.",
            "primary_fdf" => "fdf_0_40_94800831648885.fdf",
            "secondary_fdf" => "fdf_8_86_47981190087655.fdf",
            "producer" => 2,
            "mailed_date" => "2014-11-10 03:29:12",
            "p_m_eligible_payer_id" => "8104",
            "p_m_eligible_payer_name" => "Noemie Howe",
            "eligible_token" => "Yylb8gLwrgGCwbf",
            "percase_date" => "2008-01-31 19:13:17",
            "percase_name" => "Reta Gerlach MD",
            "percase_amount" => "2.58",
            "percase_status" => 7,
            "percase_invoice" => 8,
            "primary_claim_id" => 7,
            "fo_paid_viewed" => 5,
            "bo_paid_viewed" => 9,
            "primary_claim_version" => 0,
            "secondary_claim_version" => 8,
            "icd_ind" => 4,
            "name_referring_provider_qualifier" => "RF",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'patient_firstname' => 'updated patient firstname',
            'userid'            => 7,
            'docid'             => 8,
        ];
    }

    public function testGetRejected()
    {
        $this->post(self::ROUTE_PREFIX . '/insurances/rejected');
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }

    public function testGetFrontOfficeClaims()
    {
        $type = 'pending-claims';
        $this->post(self::ROUTE_PREFIX . '/insurances/' . $type);
        $this->assertResponseOk();
        $expected = [
            'total' => 0,
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testRemoveClaim()
    {
        /** @var Insurance $insurance */
        $insurance = factory($this->getModel())->create();
        $insurance->status = Insurance::DSS_CLAIM_PENDING;
        $insurance->save();
        $insuranceId = $insurance->insuranceid;
        $this->post(self::ROUTE_PREFIX . '/insurances/remove-claim', ['claim_id' => $insuranceId]);
        $this->assertResponseOk();
        $this->notSeeInDatabase($this->model->getTable(), ['insuranceid' => $insuranceId]);
    }
}
