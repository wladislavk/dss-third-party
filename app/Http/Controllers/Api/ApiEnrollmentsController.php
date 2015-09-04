<?php namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Interfaces\EnrollmentInterface;

class ApiEnrollmentsController extends ApiBaseController
{

    /**
     * @var
     */
    protected $enrollments;

    /**
     *
     * @param EnrollmentInterface $enrollments
     */
    public function __construct(EnrollmentInterface $enrollments)
    {
        $this->enrollments = $enrollments;
    }

    public function payersList()
    {

    }

    public function index()
    {

    }

    public function store()
    {

    }

    public function create()
    {

    }

    public function show()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }

}
