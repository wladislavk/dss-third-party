<?php

namespace DentalSleepSolutions\Eligible\Webhooks;

use DentalSleepSolutions\Eloquent\EligibleResponse;
use DentalSleepSolutions\Eloquent\Enrollments\Enrollment;

class EnrollmentsHandler
{
    use ProcessingWebhooksTrait;

    /**
     * enrollment_status event
     *
     * @param object $content
     * @return mixed
     */
    public function enrollmentStatus($content)
    {
        $enrollment_statuses = [
            'submitted' => Enrollment::DSS_ENROLLMENT_SUBMITTED,
            'accepted' => Enrollment::DSS_ENROLLMENT_ACCEPTED,
            'rejected' => Enrollment::DSS_ENROLLMENT_REJECTED,
        ];

        if (isset($enrollment_statuses[$content->details->status])) {
            Enrollment::setStatus($content->details->id, $enrollment_statuses[$content->details->status]);
        }

        return $content->details->id;
    }

    /**
     * enrollment_status event
     *
     * @param $content
     * @return mixed
     */
    public function receivedPdf($content)
    {
        $url = $content->details->received_pdf->download_url;
        if ($url) {
            Enrollment::setStatus($content->details->id, Enrollment::DSS_ENROLLMENT_PDF_RECEIVED);
            Enrollment::setDownloadUrl($content->details->id, $url);
        }

        return $content->details->id;
    }

    /**
     * repeat run last webhooks handler
     *
     * @param $reference_id
     */
    public function updateChanges($reference_id)
    {
        $response = EligibleResponse::getWhere($reference_id, ['enrollment_status', 'receivedPdf']);

        if ($response) {
            $this->callHandler($response->response, $this);
        }
    }
}
