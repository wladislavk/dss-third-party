<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Enrollments\Enrollment;
use Tests\TestCases\ApiTestCase;

class EligibleEnrollmentApiTest extends ApiTestCase
{
    public function testUpdateEnrollment()
    {
        /** @var Enrollment $enrollment */
        $enrollment = factory(Enrollment::class)->create();
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
            'email' => 'brendan@ignitedcoder.com',
        ];

        $this->post("/api/v1/enrollments/update/{$enrollment->id}", $data);
        $this->seeStatusCode(200);
    }

    public function testRetrieveEnrollment()
    {

        $this->get('/api/v1/enrollments/retrieve/123');
        $this->seeStatusCode(200);
    }
}
