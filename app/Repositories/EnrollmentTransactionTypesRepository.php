<?php namespace DentalSleepSolutions\Repositories;


use DentalSleepSolutions\Interfaces\EnrollmentTransactionTypesInterface;

class EnrollmentTransactionTypesRepository extends BaseRepository implements EnrollmentTransactionTypesInterface
{

    /**
     *
     * @var string
     *
     * Main model name for the Enrollment  Payers Model
     */
    protected $modelName = 'DentalSleepSolutions\EnrollmentTransactionTypes';

    /**
     *
     *
     * @return mixed
     */
    public function getTransactionTypesList()
    {
        return $this->lists('description','transction_type');
    }
}