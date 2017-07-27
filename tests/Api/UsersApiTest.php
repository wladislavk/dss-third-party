<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\User;
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
}
