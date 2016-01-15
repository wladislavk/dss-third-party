<?php namespace DentalSleepSolutions\Repositories;


use DentalSleepSolutions\Eloquent\UserSignature;
use DentalSleepSolutions\Interfaces\UserSignaturesInterface;

class UserSignaturesRepository extends BaseRepository implements UserSignaturesInterface
{
    /**
     *
     * @var string
     *
     * Main model name for the Enrollment  Payers Model
     */
    protected $modelName = UserSignature::class;
}
