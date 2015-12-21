<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreComplaintRequest;
use DentalSleepSolutions\Http\Requests\UpdateComplaintRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\ComplaintInterface;

class ApiComplaintController extends ApiBaseController
{
    /**
     * References the complaint interface
     * 
     * @var $complaint
     */
    protected $complaint;

    /**
     * 
     * @param ComplaintInterface $complaint
     */
    public function __construct(ComplaintInterface $complaint)
    {
        $this->complaint = $complaint;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $retrievedComplaints = $this->complaint->all();

        if (!count($retrievedComplaints)) {
            return ApiResponse::responseError('The table is empty.', 422);
        }

        return ApiResponse::responseOk('Complaints list.', $retrievedComplaints);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreComplaintRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->complaint->store($postValues);

        return ApiResponse::responseOk('Complaint was added successfully.', $this->complaint->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateComplaintRequest $request, $id)
    {
        $this->complaint->update($id, $request->all());

        return ApiResponse::responseOk('Complaint was updated successfully.', $this->complaint->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedComplaint = $this->complaint->find($id);

        if (empty($retrievedComplaint)) {
            return ApiResponse::responseError('Complaint not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved complaint by id.', $retrievedComplaint);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return ApiResponse::responseOk('Complaint was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedComplaint = $this->complaint->destroy($id);

        if (empty($deletedComplaint)) {
            return ApiResponse::responseError('Complaint not found.', 422);
        }

        return ApiResponse::responseOk('Complaint was deleted successfully.', $this->complaint->all());
    }
}
