<?php namespace DentalSleepSolutions\Interfaces;

use DentalSleepSolutions\BusinessObject\Enrollment;

interface EnrollmentInterface
{

    /**
     *
     *
     * @param $payerId
     * @return mixed
     */
    public function getRequiredFieldsForEnrollment($payerId);

    /**
     *
     *
     * @param array $enrollmentParams
     * @return mixed
     */
    public function createEnrollment(array $enrollmentParams);

    public function retrieveEnrollment();
    public function listEnrollments();

}
