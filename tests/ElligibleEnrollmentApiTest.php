<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ElligibleEnrollmentApiTest extends TestCase
{
    use WithoutMiddleware;

    public function testCreateEnrollment()
    {
        $date = date("Y-m-d");

        $data = ['user_id' => 1,
            'payer_id' => '00901',
            'facility_name' => 'Test Dental Center Enrollment',
            'provider_name' => 'Test Provider Name',
            'npi' => '9087654498',
            'transaction_type' => '270',
            'tax_id' => '1234567890',
            'address' => '123 Test Ave',
            'city' => 'Test City',
            'state' => 'WA',
            'zip' => '98086',
            'title' => 'Mr',
            'first_name' => 'Brendan',
            'last_name' => 'Rehman',
            'contact_number' => '425-835-1871',
            'email' => 'brendan@ignitedcoder.com'
            ,];

        $this->post('/api/v1/enrollments/create',$data)
            ->seeStatusCode(200)
            ->seeInDatabase('dental_eligible_enrollment',['facility_name' => 'Test Dental Center Enrollment']);
    }

    public function testUpdateEnrollment()
    {

        $data = [
            'user_id' => 1,
            'payer_id' => '00282',
            'effective_date' => '2012-12-24',
            'facility_name' => 'Quality',
            'provider_name' => 'Jane Austen',
            'tax_id' => '12345678',
            'address' => '125 Snow Shoe Road',
            'city' => 'Sacramento',
            'state' => 'CA',
            'zip' => '94107',
            'npi' => '0987654321',
            'title' => 'Mr',
            'first_name' => 'Brendan',
            'last_name' => 'Rehman',
            'contact_number' => '425-835-1871',
            'email' => 'brendan@ignitedcoder.com'
            ,];

        $this->post('/api/v1/enrollments/update/123',$data)->seeStatusCode(200);

    }


    public function testRetrieveEnrollment()
    {
        $this->get('/api/v1/enrollments/retrieve/123')
            ->seeStatusCode(200);
    }

    /*
    public function testListEnrollments()
    {

    }


*/

}
