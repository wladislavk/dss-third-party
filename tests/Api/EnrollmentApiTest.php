<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DentalSleepSolutions\Eloquent\Models\Enrollments\Enrollment;
use Tests\TestCases\ApiTestCase;

class EnrollmentApiTest extends ApiTestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /** @var int */
    private $enrollmentId = 0;

    public function testSendCorrectly()
    {
        // @todo: this test is volatile because numbers must be unique. devise a way to destroy records in tearDown()
        $npi = '' . rand(1000000000, 9999999999);
        $data = [
            'user_id' => 1,
            'provider_id' => 1,
            'payer_id' => '00901-test',
            'transaction_type_id' => 1,
            'facility_name' => 'Quality',
            'provider_name' => 'Jane Austen',
            'npi' => $npi,
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

        $this->post('/api/v1/enrollments/create', $data);
        $this
            ->seeJson(['status' => "Unprocessable Entity"])
            ->assertResponseStatus(422)
        ;
    }

    public function testSendEmptyData()
    {
        $data = [];

        $this
            ->post('/api/v1/enrollments/create', $data)
            ->seeJson(['status' => "Unprocessable Entity"])
            ->assertResponseStatus(422)
        ;
    }

    public function testOriginalSignatureCorrectly()
    {
        $this->markTestSkipped(
            'The business logic makes a call to a non-existent route. See DentalSleepSolutions\Eligible\Client:277'
        );
        return;
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
        $npi = '1154324101';
        $data = [
            'user_id' => 1,
            'npi' => $npi,
            'reference_id' => $reference_id,
        ];

        $this->call('POST', '/api/v1/enrollments/original-signature/send', $data, [], ['original_signature' => $file]);
        $this->seeJson(['status' => "OK"]);
        $this->seeInDatabase(
            'dental_eligible_enrollment',
            [
                'reference_id' => $reference_id,
                'status' => Enrollment::DSS_ENROLLMENT_ACCEPTED,
            ]
        );
    }

    public function testList()
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        $userId = $user->userid;
        /** @var Enrollment $enrollment */
        $enrollment = factory(Enrollment::class)->create([
            'user_id' => $userId,
        ]);
        $this->enrollmentId = $enrollment->id;

        $content = $this->call('GET', "/api/v1/enrollments/list/{$userId}")->getContent();
        $content = json_decode($content);

        $this->assertTrue(isset($content->data));
        $this->assertEquals(1, count($content->data));
    }

    public function tearDown()
    {
        if ($this->enrollmentId) {
            /** @var Enrollment|null $record */
            $record = DB::table('dental_eligible_enrollment')
                ->where('id', $this->enrollmentId);
            if ($record) {
                $record->delete();
            }
        }
        parent::tearDown();
    }
}
