<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreAssessmentRequest;
use DentalSleepSolutions\Http\Requests\UpdateAssessmentRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\AssessmentInterface;

class ApiAssessmentController extends ApiBaseController
{
    /**
     * References the assessment interface
     * 
     * @var $assessment
     */
    protected $assessment;

    /**
     * 
     * @param AssessmentInterface $assessment 
     */
    public function __construct(AssessmentInterface $assessment)
    {
        $this->assessment = $assessment;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $retrievedAssessments = $this->assessment->all();

        if (!count($retrievedAssessments)) {
            return ApiResponse::responseError('The table is empty', 422);
        }

        return ApiResponse::responseOk('Assessments list.', $retrievedAssessments);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAssessmentRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->assessment->store($postValues);

        return ApiResponse::responseOk('Assessment was added successfully.', $this->assessment->all());
    }

    /**
     * 
     * 
     * @param integer $assessmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAssessmentRequest $request, $assessmentId)
    {
        $this->assessment->update($assessmentId, $request->all());

        return ApiResponse::responseOk('Assessment was updated successfully.', $this->assessment->all());
    }

    /**
     * 
     * 
     * @param integer $assessmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($assessmentId)
    {
        $retrievedAssessment = $this->assessment->find($assessmentId);

        if (empty($retrievedAssessment)) {
            return ApiResponse::responseError('Assessment not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved assessment by id.', $retrievedAssessment);
    }

    /**
     * 
     * 
     * @param integer $assessmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($assessmentId)
    {
        return ApiResponse::responseOk('Assessment was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $assessmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($assessmentId)
    {
        $deletedAssessment = $this->assessment->destroy($assessmentId);

        if (empty($deletedAssessment)) {
            return ApiResponse::responseError('Assessment not found.', 422);
        }

        return ApiResponse::responseOk('Assessment was deleted successfully.', $this->assessment->all());
    }
}
