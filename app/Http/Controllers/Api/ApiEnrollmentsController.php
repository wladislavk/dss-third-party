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
        $status = null;
        $response = ['status' => null,'message' => 'Memo list','data' => []];
        try {
            $response['data'] = $this->enrollments->listPayers();
            $response['status'] = true;
            $status = 200;
        } catch(Exception $ex) {
            $status = 404;
            $response['status'] = false;
            return $this->createErrorResponse('Could not retrieve list of Payers', $status);
        } finally {
            return response()->json($response,$status);
        }
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
