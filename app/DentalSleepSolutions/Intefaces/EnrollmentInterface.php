<?php namespace DentalSleepSolutions\Interfaces;

interface EnrollmentInterface
{
    /**
     * Fetches a list of payers from our local DB that require enrollment.
     *
     * @return mixed
     */
    public function listPayers();

    /**
     * Gets a payer from our local DB by payerId
     *
     * @param string $payerId
     * @return mixed
     */
    public function getPayerById($payerId);

    /**
     *
     *
     * @param $payerId
     * @return mixed
     */
    public function getPayerSupportedEndpoints($payerId);

    /**
     * Queries our local database for a payer name
     * e.g. name = 'ABC' will search the names field for a name that contains ABC
     *
     * @param string $name
     * @return mixed
     */
    public function findPayerByName($name);

    /**
     *
     *
     * @param $name
     * @return mixed
     */
    public function findPayerWhereNameContains($name);

    /**
     *
     *
     * @return mixed
     */
    public function syncPayersFromProvider();


    public function createEnrollment();
    public function retrieveEnrollment();
    public function listEnrollments();


}
