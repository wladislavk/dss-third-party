<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreAccessCodeRequest;
use DentalSleepSolutions\Http\Requests\UpdateAccessCodeRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\AccessCodeInterface;

class ApiAccessCodeController extends ApiBaseController
{
    /**
     * References the access code interface
     * 
     * @var $accessCode
     */
    protected $accessCode;

    /**
     * 
     * @param AccessCodeInterface $accessCode 
     */
    public function __construct(AccessCodeInterface $accessCode)
    {
        $this->accessCode = $accessCode;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $retrievedAccessCodes = $this->accessCode->all();

        if (!count($retrievedAccessCodes)) {
            return ApiResponse::responseError('The table is empty', 422);
        }

        return ApiResponse::responseOk('Access codes list.', $retrievedAccessCodes);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAccessCodeRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->accessCode->store($postValues);

        return ApiResponse::responseOk('Access code was added successfully.', $this->accessCode->all());
    }

    /**
     * 
     * 
     * @param integer $id 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAccessCodeRequest $request, $id)
    {
        $this->accessCode->update($id, $request->all());

        return ApiResponse::responseOk('Access code was updated successfully.', $this->accessCode->all());
    }

    /**
     * 
     * 
     * @param integer $id 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedAccessCode = $this->accessCode->find($id);

        if (empty($retrievedAccessCode)) {
            return ApiResponse::responseError('Access code not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved access code by id.', $retrievedAccessCode);
    }

    /**
     * 
     * 
     * @param integer $id 
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return ApiResponse::responseOk('Access code was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $id 
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedAccessCode = $this->accessCode->destroy($id);

        if (empty($deletedAccessCode)) {
            return ApiResponse::responseError('Access code not found.', 422);
        }

        return ApiResponse::responseOk('Access code was deleted successfully.', $this->accessCode->all());
    }
}
