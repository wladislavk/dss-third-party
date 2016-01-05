<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreContactTypeRequest;
use DentalSleepSolutions\Http\Requests\UpdateContactTypeRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\ContactTypeInterface;

class ApiContactTypeController extends ApiBaseController
{
    /**
     * References the contact type interface
     * 
     * @var $contactType
     */
    protected $contactType;

    /**
     * 
     * @param ContactTypeInterface $contactType 
     */
    public function __construct(ContactTypeInterface $contactType)
    {
        $this->contactType = $contactType;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $contactTypes = $this->contactType->all();

        if (!count($contactTypes)) {
            return ApiResponse::responseOk('The table is empty.', $contactTypes);
        }

        return ApiResponse::responseOk('Contact types list.', $contactTypes);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreContactTypeRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->contactType->store($postValues);

        return ApiResponse::responseOk('Contact type was added successfully.');
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateContactTypeRequest $request, $id)
    {
        $this->contactType->update($id, $request->all());

        return ApiResponse::responseOk('Contact type was updated successfully.');
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedContactType = $this->contactType->find($id);

        if (empty($retrievedContactType)) {
            return ApiResponse::responseError('Contact type not found.', 404);
        }

        return ApiResponse::responseOk('Retrieved contact type by id.', $retrievedContactType);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedContactType = $this->contactType->destroy($id);

        if (empty($deletedContactType)) {
            return ApiResponse::responseError('Contact type not found.', 404);
        }

        return ApiResponse::responseOk('Contact type was deleted successfully.');
    }
}
