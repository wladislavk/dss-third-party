<?php namespace DentalSleepSolutions\Interfaces;

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
     * @param null $apiKey
     * @return mixed
     */
    public function createEnrollment(array $enrollmentParams, $apiKey=null);

    /**
     *
     *
     * @param int $enrollmentId
     * @param array $enrollmentParams
     * @param string $apiKey
     * @return mixed
     */
    public function updateEnrollment($enrollmentId = 0,array $enrollmentParams, $apiKey = '');

    /**
     *
     *
     * @param int $enrollmentId
     * @param array $enrollmentParams
     * @param null $apiKey
     * @return mixed
     */
    public function retrieveEnrollment($enrollmentId=0, array $enrollmentParams = [], $apiKey=null);

    /**
     *
     *
     * @param int $page
     * @param null $apiKey
     * @return mixed
     */
    public function listEnrollments($page=1, $apiKey=null);

    /**
     *
     *
     * @param array $data
     * @return void
     */
    public function saveEnrollmentDetailsToDatabase(array $data = []);

}
