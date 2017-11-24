<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Models\User as BaseUser;
use Tests\TestCases\ApiTestCase;

class UsersApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return User::class;
    }

    protected function getRoute()
    {
        return '/users';
    }

    protected function getStoreData()
    {
        return [
            "user_access" => 3,
            "docid" => 100,
            "username" => "rashawn.smitham",
            "npi" => "8732728180",
            "name" => "Friedrich Runolfsson",
            "email" => "lbartoletti@krajcik.com",
            "address" => "784 Padberg Oval Suite 041\nLake Blanca, FL 07469-9528",
            "city" => "Hegmanntown",
            "state" => "NJ",
            "zip" => "18658",
            "phone" => "7311073721",
            "status" => 9,
            "medicare_npi" => "9007925670",
            "tax_id_or_ssn" => "amet",
            "producer" => 3,
            "practice" => "Animi est non velit atque atque.",
            "email_header" => "dss_email_header_857562_5949.png",
            "email_footer" => "dss_email_footer_585267_2130.gif",
            "fax_header" => "dss_print_header_582588_2242.jpg",
            "fax_footer" => "dss_print_footer_098179_7824.bmp",
            "recover_hash" => "rntob2vjpygoiga04qh4tbfa7oiyhgz9tp510s8nmsc1sz2dedorpp2dux4cvenv0",
            "recover_time" => "1981-06-29 08:27:31",
            "ssn" => 1,
            "ein" => 0,
            "use_patient_portal" => 1,
            "mailing_practice" => "voluptates",
            "mailing_name" => "Mustafa O'Connell V",
            "mailing_address" => "9302 Friesen Track\nEast Germaineberg, GA 88612-2158",
            "mailing_city" => "Adrienborough",
            "mailing_state" => "NJ",
            "mailing_zip" => "22970",
            "mailing_phone" => "9324548217",
            "last_accessed_date" => "1981-09-06 02:30:17",
            "use_digital_fax" => 1,
            "fax" => "2137418857",
            "use_letters" => 0,
            "sign_notes" => 4,
            "use_eligible_api" => 1,
            "access_code" => "U4440",
            "text_date" => "2006-10-14 10:35:26",
            "text_num" => 5,
            "access_code_date" => "2016-03-30 06:28:26",
            "registration_email_date" => "2009-08-07 09:20:25",
            "producer_files" => 1,
            "medicare_ptan" => "porro",
            "use_course" => 0,
            "use_course_staff" => 1,
            "manage_staff" => 0,
            "cc_id" => "cus_kf2eB6j",
            "user_type" => 6,
            "letter_margin_header" => 7,
            "letter_margin_footer" => 4,
            "letter_margin_top" => 5,
            "letter_margin_bottom" => 1,
            "letter_margin_left" => 5,
            "letter_margin_right" => 9,
            "claim_margin_top" => 7,
            "claim_margin_left" => 4,
            "logo" => "user_logo_96.jpg",
            "homepage" => 0,
            "use_letter_header" => 1,
            "access_code_id" => 2,
            "first_name" => "Carmel",
            "last_name" => "Hudson",
            "indent_address" => 0,
            "registration_date" => "1996-08-17 09:16:47",
            "header_space" => 6,
            "billing_company_id" => 9,
            "edx_id" => 5,
            "help_id" => 9,
            "tracker_letters" => 4,
            "intro_letters" => 6,
            "plan_id" => 0,
            "suspended_reason" => "neque",
            "suspended_date" => "1990-06-12 07:36:24",
            "signature_file" => "voluptatem",
            "signature_json" => "et",
            "use_service_npi" => 4,
            "service_name" => "Jewell Gottlieb",
            "service_address" => "76097 Viva Gateway Suite 947\nGoodwinview, VT 49701-0193",
            "service_city" => "Clotildeshire",
            "service_state" => "IN",
            "service_zip" => "47051",
            "service_phone" => "1497775187",
            "service_fax" => "5482423105",
            "service_npi" => "2",
            "service_medicare_npi" => "9",
            "service_medicare_ptan" => "et",
            "service_tax_id_or_ssn" => "est",
            "service_ssn" => 0,
            "service_ein" => 8,
            "eligible_test" => 2,
            "billing_plan_id" => 5,
            "post_ledger_adjustments" => 5,
            "edit_ledger_entries" => 6,
            "use_payment_reports" => 4,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'docid'    => 876,
            'username' => 'John Doe',
            'zip'      => '12345',
        ];
    }

    public function testCheck()
    {
        $this->post(self::ROUTE_PREFIX . '/users/check');
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }

    public function testGetCurrentUserInfo()
    {
        /** @var BaseUser $user */
        $user = BaseUser::find('u_1');
        $this->be($user);
        $this->get(self::ROUTE_PREFIX . '/users/current');
        $this->assertResponseOk();
        $expected = [
            'id' => 'u_1',
            'adminid' => 0,
            'userid' => 1,
            'docid' => 1,
            'user_type' => 2,
            'status' => 1,
            'admin' => 0,
            'email' => 'email1@email.com',
            'name' => 'DOCTOR !',
            'first_name' => 'Doctor',
            'last_name' => '1',
            'username' => 'doc1f',
            'ip_address' => '192.168.1.55',
            'access' => 2,
            'companyid' => 3,
            'adddate' => '2010-03-05 18:53:39',
            'use_course' => 1,
            'numbers' => [
                'patient_contacts' => 0,
                'patient_insurances' => 1,
                'payment_reports' => 1,
                'support_tickets' => 5,
                'patient_changes' => 4,
                'pending_duplicates' => 9,
                'email_bounces' => 0,
                'completed_preauth' => 6,
                'pending_preauth' => 2,
                'rejected_preauth' => 0,
                'completed_hst' => 4,
                'requested_hst' => 1,
                'rejected_hst' => 0,
                'pending_claims' => 6,
                'rejected_claims' => 3,
                'unmailed_claims' => 71,
                'unmailed_claims_software' => 71,
                'fax_alerts' => 0,
                'pending_letters' => 250,
                'unmailed_letters' => 130,
                'unsigned_notes' => 7,
            ],
            'doc_info' => [
                'userid' => 1,
                'user_access' => 2,
                'docid' => 0,
                'username' => 'doc1f',
                'npi' => '1234567890',
                'name' => 'DOCTOR !',
                'email' => 'email1@email.com',
                'address' => '125 Sleepy Hollow Lane1',
                'city' => 'St Pete',
                'state' => 'CA',
                'zip' => '33333',
                'phone' => '5554443333',
                'status' => 1,
                'adddate' => '2010-03-05 18:53:39',
                'ip_address' => '192.168.1.55',
                'medicare_npi' => '1234567890',
                'tax_id_or_ssn' => '8888',
                'producer' => null,
                'practice' => 'Test Practice2',
                'email_header' => 'dss_email_header_250711_1609.jpg',
                'email_footer' => 'dss_email_footer_250711_1609.jpg',
                'fax_header' => 'dss_print_header_250711_1609.jpg',
                'fax_footer' => 'dss_print_footer_250711_1609.jpg',
                'recover_hash' => 'd67d76236b805f4d3b830374d313667f62eede287ace7b17b65dfbffe5a8be0c',
                'recover_time' => '2011-08-31 13:00:05',
                'ssn' => 0,
                'ein' => 1,
                'use_patient_portal' => 1,
                'mailing_practice' => 'Test Practice',
                'mailing_name' => 'Dental Sleep Solutions',
                'mailing_address' => '123 Test St, Ste 205',
                'mailing_city' => 'St. Petersburg',
                'mailing_state' => 'FL',
                'mailing_zip' => '33704',
                'mailing_phone' => '5555555555',
                'use_digital_fax' => 1,
                'fax' => '',
                'use_letters' => 1,
                'sign_notes' => 0,
                'use_eligible_api' => 1,
                'access_code' => null,
                'text_date' => null,
                'text_num' => 0,
                'access_code_date' => null,
                'registration_email_date' => null,
                'producer_files' => 0,
                'medicare_ptan' => '123321',
                'use_course' => 1,
                'use_course_staff' => 1,
                'manage_staff' => 0,
                'cc_id' => 'cus_2sh7VzTQufIsgX',
                'user_type' => 2,
                'letter_margin_header' => 48,
                'letter_margin_footer' => 26,
                'letter_margin_top' => 14,
                'letter_margin_bottom' => 40,
                'letter_margin_left' => 18,
                'letter_margin_right' => 18,
                'claim_margin_top' => 10,
                'claim_margin_left' => 10,
                'homepage' => 1,
                'logo' => 'user_logo_1.jpg',
                'use_letter_header' => 0,
                'access_code_id' => 1,
                'first_name' => 'Doctor',
                'last_name' => '1',
                'indent_address' => 0,
                'registration_date' => null,
                'header_space' => 0,
                'billing_company_id' => 4,
                'tracker_letters' => 1,
                'intro_letters' => 1,
                'plan_id' => 1,
                'suspended_reason' => null,
                'suspended_date' => null,
                'updated_at' => '2016-01-12 15:15:29',
                'signature_file' => null,
                'signature_json' => null,
                'edx_id' => 354,
                'help_id' => 5,
                'use_service_npi' => 0,
                'service_name' => 'MedicareName',
                'service_address' => 'MedicareAddr',
                'service_city' => 'MedCity',
                'service_state' => 'MedState',
                'service_zip' => '99999',
                'service_phone' => '',
                'service_fax' => '',
                'service_npi' => '99999999',
                'service_medicare_npi' => '99999999',
                'service_medicare_ptan' => '88888999',
                'service_tax_id_or_ssn' => '99999999',
                'service_ssn' => 0,
                'service_ein' => 0,
                'eligible_test' => 1,
                'billing_plan_id' => 0,
                'post_ledger_adjustments' => 0,
                'edit_ledger_entries' => 0,
                'use_payment_reports' => 1,
                'is_billing_exclusive' => 0,
            ],
        ];
        $response = $this->getResponseData();
        unset($response['doc_info']['last_accessed_date']);
        $this->assertEquals($expected, $response);
    }

    public function testCheckLogout()
    {
        $this->post(self::ROUTE_PREFIX . '/users/check-logout');
        $this->assertResponseOk();
        $expected = [
            'logout' => true,
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testGetLetterInfo()
    {
        $this->post(self::ROUTE_PREFIX . '/users/letter-info');
        $this->assertResponseOk();
        $this->assertNull($this->getResponseData());
    }
}
