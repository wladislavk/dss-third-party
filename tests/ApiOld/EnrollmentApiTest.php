<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tests\TestCases\BaseApiTestCase;
use DentalSleepSolutions\Eloquent\Models\Enrollments\Enrollment;

class EnrollmentApiTest extends BaseApiTestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /** @var int */
    private $enrollmentId = 0;

    public function testStoreSendCorrectly()
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
            'contact_number' => '1478963251',
            'email' => 'provider@eligibleapi.com',
        ];

        $this->post(self::ROUTE_PREFIX . '/enrollments/create', $data);
        $this->seeJson(['status' => 'OK']);
        $this->seeInDatabase('dental_eligible_enrollment', ['payer_id' => '00901']);
    }

    public function testStoreSendWrongPayerId()
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
            'contact_number' => '1478963251',
            'email' => 'provider@eligibleapi.com',
        ];

        $this->post(self::ROUTE_PREFIX . '/enrollments/create', $data);
        $this
            ->seeJson(['status' => "Unprocessable Entity"])
            ->assertResponseStatus(422)
        ;
    }

    public function testStoreSendEmptyData()
    {
        $data = [];

        $this
            ->post(self::ROUTE_PREFIX . '/enrollments/create', $data)
            ->seeJson(['status' => "Unprocessable Entity"])
            ->assertResponseStatus(422)
        ;
    }

    public function testUploadOriginalSignaturePdfCorrectly()
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

        $this->call('POST', self::ROUTE_PREFIX . '/enrollments/original-signature/send', $data, [], ['original_signature' => $file]);
        $this->seeJson(['status' => "OK"]);
        $this->seeInDatabase(
            'dental_eligible_enrollment',
            [
                'reference_id' => $reference_id,
                'status' => Enrollment::DSS_ENROLLMENT_ACCEPTED,
            ]
        );
    }

    public function testListEnrollments()
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        $userId = $user->userid;
        /** @var Enrollment $enrollment */
        $enrollment = factory(Enrollment::class)->create([
            'user_id' => $userId,
        ]);
        $this->enrollmentId = $enrollment->id;

        $content = $this->call('GET', self::ROUTE_PREFIX . "/enrollments/list/{$userId}")->getContent();
        $content = json_decode($content);

        $this->assertTrue(isset($content->data));
        $this->assertEquals(1, count($content->data));
    }

    public function testGetPayersList()
    {
        $type = 1;
        $this->get(self::ROUTE_PREFIX . '/enrollments/payers/' . $type);
        $this->assertResponseOk();
        $result = json_decode($this->response->getContent(), true);
        $this->assertEquals(79, count($result));
        $expectedFirst = [
            'payer_id' => '00901',
            'names' => [
                'Medicare Part B of Maryland',
                'Medicare of Maryland',
                'Medicare of Maryland Jurisdiction A',
            ],
            'created_at' => '2014-07-20T07:17:21Z',
            'supported_endpoints' => [
                [
                    'endpoint' => 'coverage',
                    'pass_through_fee' => 0,
                    'enrollment_required' => true,
                    'signature_required' => false,
                    'average_enrollment_process_time' => '1 day',
                    'blue_ink_required' => false,
                    'message' => '',
                    'enrollment_mandatory_fields' => ['npi'],
                    'status' => 'available',
                    'status_details' => 'Payer is working fine.',
                    'status_updated_at' => '2017-05-11T14:01:17Z',
                    'original_signature_pdf' => false,
                    'credentials_required' => false,
                ],
            ],
        ];
        unset($result[0]['updated_at']);
        $this->assertEquals($expectedFirst, $result[0]);
    }

    public function testUpdateEnrollment()
    {
        $id = 1;
        $data = [
            'payer_id'          => 1,
            'facility_name'     => 'facility',
            'provider_name'     => 'provider',
            'npi'               => 'npi',
        ];
        $this->post(self::ROUTE_PREFIX . '/enrollments/update/' . $id, $data);
        $this->assertResponseOk();
        $this->assertEquals('"enrollment_npi should not be blank."', $this->response->getContent());
    }

    public function testRetrieveEnrollment()
    {
        $id = 1;
        $this->get(self::ROUTE_PREFIX . '/enrollments/retrieve/' . $id);
        $this->assertResponseOk();
        $result = json_decode($this->response->getContent(), true);
        $decodedResult = json_decode($result, true);
        $this->assertEquals('Enrollment Npi not found.', $decodedResult['error']);
    }

    public function testGetDentalUserCompanyApiKey()
    {
        $userId = 1;
        $this->get(self::ROUTE_PREFIX . '/enrollments/apikey/' . $userId);
        $this->assertResponseOk();
        $expected = [
            "eligible_api_key" => "hCmEKZG7_KQ8mS4ztO3EJWKP1KEWvwW5Bdvx",
        ];
        $result = json_decode($this->response->getContent(), true);
        $this->assertEquals($expected, $result);
    }

    public function testGetEnrollmentTransactionType()
    {
        $id = 1;
        $this->get(self::ROUTE_PREFIX . '/enrollments/type/' . $id);
        $this->assertResponseOk();
        $expected = [
            'id' => 1,
            'transaction_type' => '270',
            'description' => 'Eligibility / Coverage',
            'adddate' => '2014-03-18 20:26:51',
            'ip_address' => null,
            'status' => 1,
            'endpoint_type' => 'coverage',
        ];
        $result = json_decode($this->response->getContent(), true);
        $this->assertEquals($expected, $result);
    }

    public function testSyncEnrollmentPayers()
    {
        $this->get(self::ROUTE_PREFIX . '/enrollments/syncpayers');
        $this->assertResponseOk();
        $this->assertEquals(79, count($this->getResponseData()));
        $expectedFirst = [
            'payer_id' => '00901',
            'names' => [
                'Medicare Part B of Maryland',
                'Medicare of Maryland',
                'Medicare of Maryland Jurisdiction A',
            ],
            'created_at' => '2014-07-20T07:17:21Z',
            'supported_endpoints' => [
                [
                    'endpoint' => 'coverage',
                    'pass_through_fee' => 0,
                    'enrollment_required' => true,
                    'signature_required' => false,
                    'average_enrollment_process_time' => '1 day',
                    'blue_ink_required' => false,
                    'message' => '',
                    'enrollment_mandatory_fields' => ['npi'],
                    'status' => 'available',
                    'status_details' => 'Payer is working fine.',
                    'status_updated_at' => '2017-05-11T14:01:17Z',
                    'original_signature_pdf' => false,
                    'credentials_required' => false,
                ],
            ],
        ];
        $first = $this->getResponseData()[0];
        unset($first['updated_at']);
        $this->assertEquals($expectedFirst, $first);
    }

    public function tearDown()
    {
        if ($this->enrollmentId) {
            /** @var Enrollment|null $record */
            $record = \DB::table('dental_eligible_enrollment')
                ->where('id', $this->enrollmentId);
            if ($record) {
                $record->delete();
            }
        }
        parent::tearDown();
    }
}
