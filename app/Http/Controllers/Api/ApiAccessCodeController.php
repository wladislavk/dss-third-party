<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\Request;
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
     * Validation rules for the store and update methods
     * 
     * @var array
     */
    private $rules = [
        'access_code' => 'string',
        'notes'       => 'string',
        'status'      => 'integer',
        'plan_id'     => 'integer'
    ];

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
    public function store()
    {
        $postValues = Input::all();
        $validator  = \Validator::make($postValues, $this->rules);

        if ($validator->fails()) {
            return ApiResponse::responseError($validator->errors(), 422);
        }

        $postValues = array_merge($postValues, [
            'adddate' => Carbon::now(),
            'ip_address' => \Request::ip()
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
    public function update($id)
    {
        $putValues = Input::all();
        $validator = \Validator::make($putValues, $this->rules);

        if ($validator->fails()) {
            return ApiResponse::responseError($validator->errors(), 422);
        }

        $this->accessCode->update($id, $putValues);

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
