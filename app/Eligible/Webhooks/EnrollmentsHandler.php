<?php

namespace DentalSleepSolutions\Eligible\Webhooks;

use DentalSleepSolutions\Eloquent\Models\Enrollments\Enrollment;
use DentalSleepSolutions\Eloquent\Repositories\EligibleResponseRepository;
use DentalSleepSolutions\Eloquent\Repositories\Enrollments\EnrollmentRepository;

class EnrollmentsHandler
{
    use ProcessingWebhooksTrait;

    /** @var EligibleResponseRepository */
    private $eligibleResponseRepository;

    /** @var EnrollmentRepository */
    private $enrollmentRepository;

    public function __construct(
        EligibleResponseRepository $eligibleResponseRepository,
        EnrollmentRepository $enrollmentRepository
    ) {
        $this->eligibleResponseRepository = $eligibleResponseRepository;
        $this->enrollmentRepository = $enrollmentRepository;
    }

    /**
     * enrollment_status event
     *
     * @param object $content
     * @return mixed
     */
    public function enrollmentStatus($content)
    {
        $enrollmentStatuses = [
            'submitted' => Enrollment::DSS_ENROLLMENT_SUBMITTED,
            'accepted' => Enrollment::DSS_ENROLLMENT_ACCEPTED,
            'rejected' => Enrollment::DSS_ENROLLMENT_REJECTED,
        ];

        if (isset($enrollmentStatuses[$content->details->status])) {
            $this->enrollmentRepository->setStatus($content->details->id, $enrollmentStatuses[$content->details->status]);
        }

        return $content->details->id;
    }

    /**
     * @param object $content
     * @return int
     */
    public function receivedPdf($content)
    {
        $url = $content->details->received_pdf->download_url;
        if ($url) {
            $this->enrollmentRepository->setStatus($content->details->id, Enrollment::DSS_ENROLLMENT_PDF_RECEIVED);
            $this->enrollmentRepository->setDownloadUrl($content->details->id, $url);
        }

        return $content->details->id;
    }

    /**
     * repeat run last webhooks handler
     *
     * @param int $referenceId
     */
    public function updateChanges($referenceId)
    {
        $response = $this->eligibleResponseRepository
            ->getWhere($referenceId, ['enrollment_status', 'receivedPdf']);

        if ($response) {
            $this->callHandler($response->response, $this);
        }
    }
}
