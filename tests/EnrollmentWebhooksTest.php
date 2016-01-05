<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DentalSleepSolutions\Eloquent\Enrollments\Enrollment;

class EnrollmentWebhooksTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    private $enrollmentStatusRequest = [
        'event' => 'enrollment_status',
        'details' => [
            'id' => '51',
            'facility_name' => 'Quality',
            'provider_name' => 'Austen',
            "tax_id" => "12345678",
            "address" => "125 Snow Road",
            "city" => "Sacramento",
            "state" => "CA",
            "zip" => "94107",
            "ptan" => "54321",
            "medicaid_id" => "33333",
            "npi" => "987654321",
            "status" => "rejected",
            "created_at" => "2013-12-13T14:22:04Z",
            "updated_at" => "2013-12-13T14:22:04Z",
            "reject_reasons" => ["NPI noted, 1234567890, for this enrollment is not registered with Blue Cross and Blue Shield of North Carolina. The provider should take immediate action to register this NPI with BCBSNC by contacting our BCBSNC Network Management Department at 1 800 777 1643."],
            "payer" => [
                "id" => "62308",
                "names" => [
                    "CIGNA - PPO",
                    "CIGNA Health Plan - HMO",
                    "EQUICOR"
                ],
                "endpoints" => [
                    "coverage",
                    "cost estimate",
                    "fetch and append"
                ]
            ]
        ]
    ];

    private $receivedPdfRequest = [
        "event" => "received_pdf",
        "details" => [
            "id" => 51,
            "facility_name" => "Quality",
            "provider_name" => "Austen",
            "tax_id" => "12345678",
            "address" => "125 Snow Road",
            "city" => "Sacramento",
            "state" => "CA",
            "zip" => "94107",
            "ptan" => "54321",
            "medicaid_id" => "33333",
            "npi" => "987654321",
            "status" => "submitted",
            "reject_reasons" => [],
            "created_at" => "2013-12-13T14:22:04Z",
            "updated_at" => "2013-12-13T14:22:04Z",
            "payer" => [
                "id" => "62308",
                "names" => [
                    "CIGNA - PPO",
                    "CIGNA Health Plan - HMO",
                    "EQUICOR"
                ],
                "endpoints" => [
                    "coverage",
                    "cost estimate",
                    "fetch and append"
                ]
            ],
            "received_pdf" => [
                "name" => "enrollment.pdf",
                "created_at" => "2015-01-16T15:22:44Z",
                "updated_at" => "2015-01-29T14:54:01Z",
                "download_url" => "https://gds.eligibleapi.com/v1.5/enrollment_npis/51/received_pdf/download?api_key=YOUR_API_KEY",
                "notification_message" => "Notification message sent along with the original signature pdf"
            ]
        ]
    ];


    public function testWrongRequest()
    {
        $this->json('POST', 'webhooks/enrollment');

        $this->seeStatusCode(500);
    }

    public function testEnrollmentStatusRejected()
    {
        $data = $this->enrollmentStatusRequest;

        $data['details']['status'] = 'rejected';

        $enrollment = factory(Enrollment::class)->create();
        $this->json('POST', 'webhooks/enrollment', $data);

        $this->seeStatusCode(200);
        $this->seeInDatabase(
            'dental_eligible_enrollment',
            [
                'reference_id' => $enrollment->reference_id,
                'status' => Enrollment::DSS_ENROLLMENT_REJECTED,
            ]
        );
    }

    public function testEnrollmentStatusAccepted()
    {
        $data = $this->enrollmentStatusRequest;

        $data['details']['status'] = 'accepted';

        $enrollment = factory(Enrollment::class)->create();
        $this->json('POST', 'webhooks/enrollment', $data);

        $this->seeStatusCode(200);
        $this->seeInDatabase(
            'dental_eligible_enrollment',
            [
                'reference_id' => $enrollment->reference_id,
                'status' => Enrollment::DSS_ENROLLMENT_ACCEPTED,
            ]
        );
    }

    public function testReceivedPdf()
    {
        $data = $this->receivedPdfRequest;

        $enrollment = factory(Enrollment::class)->create();
        $this->json('POST', 'webhooks/enrollment', $data);

        $this->seeStatusCode(200);
        $this->seeInDatabase(
            'dental_eligible_enrollment',
            [
                'reference_id' => $enrollment->reference_id,
                'status' => Enrollment::DSS_ENROLLMENT_PDF_RECEIVED,
            ]
        );
    }
}
