<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DentalSleepSolutions\Eloquent\Enrollments\Enrollment;

class EnrollmentApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    public function testSendCorrectly()
    {
        $data = [
            'user_id' => 1,
            'payer_id' => '00901-test',
            'transaction_type_id' => 1,
            'facility_name' => 'Quality',
            'provider_name' => 'Jane Austen',
            'npi' => '1154324101',
            'tax_id' => '12345678',
            'address' => '125 Snow Shoe Road',
            'city' => 'Sacramento',
            'state' => 'CA',
            'zip' => '94107',
            'ptan' => '54321',
            'first_name' => 'Lorem',
            'last_name' => 'Ipsum',
            //'phone' => '1478963250',
            'contact_number' => '1478963251',
            'email' => 'provider@eligibleapi.com',
        ];

        $this->post('/api/v1/enrollments/create', $data);
        $this->seeJson(['status' => 'OK']);
        $this->seeInDatabase('dental_eligible_enrollment', ['payer_id' => '00901']);
    }


    public function testSendWrongPayerId()
    {

        $data = [
            'user_id' => 1,
            'payer_id' => '00000-test',
            'transaction_type_id' => 1,
            'facility_name' => 'Quality',
            'provider_name' => 'Jane Austen',
            'npi' => '1234567890',
            'tax_id' => '12345678',
            'address' => '125 Snow Shoe Road',
            'city' => 'Sacramento',
            'state' => 'CA',
            'zip' => '94107',
            'ptan' => '54321',
            'first_name' => 'Lorem',
            'last_name' => 'Ipsum',
            //'phone' => '1478963250',
            'contact_number' => '1478963251',
            'email' => 'provider@eligibleapi.com',
        ];

        $this->post('/api/v1/enrollments/create', $data)
            ->seeJson(['status' => "Bad Request"]);
    }


    public function testSendEmptyData()
    {
        $data = [];

        $this->post('/api/v1/enrollments/create', $data)
            ->seeJson(['status' => "Unprocessable Entity"]);
    }


    public function testOriginalSignatureCorrectly()
    {
        Enrollment::where('reference_id', 51)->delete();
        factory(Enrollment::class)->create(['reference_id' => 51]);

        $file = new UploadedFile(
            base_path().'/tests/file/received_pdf_example.pdf',
            'received_pdf_example.pdf',
            'application/pdf',
            466,
            UPLOAD_ERR_OK,
            true
        );

        $reference_id = '51';
        $data = [
            'user_id' => 1,
            'npi' => '1154324101',
            'reference_id' => $reference_id,
        ];

        $this->call('POST', '/api/v1/enrollments/original-signature/send', $data, [], ['original_signature' => $file]);
        $this->seeJson(['status' => "OK"]);
        $this->seeInDatabase(
            'dental_eligible_enrollment',
            [
                'reference_id' => $reference_id,
                'status' => Enrollment::DSS_ENROLLMENT_ACCEPTED
            ]
        );
    }
}
