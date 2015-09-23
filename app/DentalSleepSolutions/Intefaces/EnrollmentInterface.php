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
     * @param array $enrollmentParams
     * @param int $enrollmentId
     * @param string $apiKey
     * @return mixed
     */
    public function updateEnrollment(array $enrollmentParams, $enrollmentId = 0, $apiKey = '');

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
    public function listEligibleEnrollments($page=1, $apiKey=null);

    /**
     *
     *
     * @param array $data
     * @return void
     */
    public function saveEnrollmentDetailsToDatabase(array $data = []);


    /**
     *
     *
     * @param int $userId
     * @return mixed
     */
    public function listEnrollments($userId);

    /**
     *
     *
     * @param int $userId
     * @return mixed
     */
    public function getUserCompanyEligibleApiKey($userId);

}
