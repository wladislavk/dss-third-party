<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\InsurancePreauth;
use Tests\TestCases\ApiTestCase;

class InsurancePreauthApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return InsurancePreauth::class;
    }

    protected function getRoute()
    {
        return '/insurance-preauth';
    }

    protected function getStoreData()
    {
        return [
            "doc_id" => 7,
            "patient_id" => 5,
            "ins_co" => "Numquam et qui illo.",
            "ins_rank" => "error",
            "ins_phone" => "6647301529",
            "patient_ins_group_id" => "6525",
            "patient_ins_id" => "20883",
            "patient_firstname" => "Mitchell",
            "patient_lastname" => "Keebler",
            "patient_add1" => "53696 Arvid Valleys Apt. 479\nSouth Garrett, ID 40505-9852",
            "patient_add2" => "7060 Wiegand Corner\nNorbertshire, AL 87544-1218",
            "patient_city" => "Mathildemouth",
            "patient_state" => "MS",
            "patient_zip" => "30558",
            "patient_dob" => "1975-08-20",
            "insured_first_name" => "Dario",
            "insured_last_name" => "Harber",
            "insured_dob" => "1987-03-13",
            "doc_npi" => "907878727",
            "referring_doc_npi" => "972882387",
            "trxn_code_amount" => "54.77",
            "diagnosis_code" => "92.10",
            "date_of_call" => "2010-10-12",
            "insurance_rep" => "mollitia",
            "call_reference_num" => "05143",
            "doc_medicare_npi" => "022058601",
            "doc_tax_id_or_ssn" => "85152",
            "ins_effective_date" => "2007-01-26",
            "ins_cal_year_start" => "2007-11-29",
            "ins_cal_year_end" => "2009-08-04",
            "trxn_code_covered" => 1,
            "code_covered_notes" => "Cum labore praesentium similique.",
            "has_out_of_network_benefits" => 3,
            "out_of_network_percentage" => 3,
            "is_hmo" => 8,
            "hmo_date_called" => "2008-06-06",
            "hmo_date_received" => "1979-12-14",
            "hmo_needs_auth" => 1,
            "hmo_auth_date_requested" => "2004-03-02",
            "hmo_auth_date_received" => "2004-09-10",
            "hmo_auth_notes" => "Ut rerum commodi quasi nisi deserunt nulla.",
            "in_network_percentage" => 0,
            "in_network_appeal_date_sent" => "2002-11-10",
            "in_network_appeal_date_received" => "2010-09-16",
            "is_pre_auth_required" => 7,
            "verbal_pre_auth_name" => "Brice",
            "verbal_pre_auth_ref_num" => "00704",
            "verbal_pre_auth_notes" => "Nihil sed ratione assumenda officiis.",
            "written_pre_auth_notes" => "Sunt saepe qui ut harum.",
            "written_pre_auth_date_received" => "1987-05-17",
            "front_office_request_date" => "1985-01-15",
            "status" => 2,
            "patient_deductible" => "15.94",
            "patient_amount_met" => "04.13",
            "family_deductible" => "47.47",
            "family_amount_met" => "96.01",
            "deductible_reset_date" => "1999-04-15",
            "out_of_pocket_met" => 6,
            "patient_amount_left_to_meet" => "01.48",
            "expected_insurance_payment" => "84.12",
            "expected_patient_payment" => "35.66",
            "network_benefits" => 4,
            "viewed" => 3,
            "date_completed" => "1977-10-19",
            "userid" => 1,
            "how_often" => "4",
            "patient_phone" => "8642206805",
            "pre_auth_num" => "769150908",
            "family_amount_left_to_meet" => "76.12",
            "deductible_from" => 2,
            "reject_reason" => "Tempore explicabo perferendis dolor molestiae quia quaerat vel expedita.",
            "invoice_date" => "1976-06-16",
            "invoice_amount" => "07.53",
            "invoice_status" => 7,
            "invoice_id" => 0,
            "updated_by" => 7,
            "doc_name" => "Loraine Schaden",
            "doc_practice" => "labore",
            "doc_address" => "5135 Hand Locks\nPort Berry, LA 10891",
            "doc_phone" => "3991649347",
            "in_deductible_from" => 4,
            "in_patient_deductible" => "59.24",
            "in_patient_amount_met" => "06.13",
            "in_patient_amount_left_to_meet" => "09.69",
            "in_family_deductible" => "80.21",
            "in_family_amount_met" => "77.91",
            "in_family_amount_left_to_meet" => "46.51",
            "in_deductible_reset_date" => "1990-12-02",
            "in_out_of_pocket_met" => 4,
            "in_expected_insurance_payment" => "42.92",
            "in_expected_patient_payment" => "68.30",
            "in_call_reference_num" => "482",
            "has_in_network_benefits" => 3,
            "in_is_pre_auth_required" => 6,
            "in_verbal_pre_auth_name" => "Prof. Bulah Price",
            "in_verbal_pre_auth_ref_num" => "Lori Hintz",
            "in_verbal_pre_auth_notes" => "Ea aut fugit totam vel eos numquam.",
            "in_written_pre_auth_date_received" => "2000-02-24",
            "in_pre_auth_num" => "910",
            "in_written_pre_auth_notes" => "Voluptas numquam autem dolores magni nemo quisquam.",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'patient_id'        => 8,
            'ins_co'            => 'test company',
            'patient_firstname' => 'John',
            'patient_lastname'  => 'Doe',
        ];
    }

    public function testFind()
    {
        $this->post(self::ROUTE_PREFIX . '/insurance-preauth/vobs/find');
        $this->assertResponseOk();
        $expected = [
            'total' => 0,
            'result' => [],
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testGetPendingVOBByContactId()
    {
        $this->post(self::ROUTE_PREFIX . '/insurance-preauth/pending-VOB');
        $this->assertResponseOk();
        $response = $this->getResponseData();
        $this->assertNotNull($response);
        $this->assertEquals(83, $response['id']);
    }
}
