<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreCustomRequest;
use DentalSleepSolutions\Http\Requests\UpdateCustomRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\CustomInterface;

class ApiCustomController extends ApiBaseController
{
    /**
     * References the Custom interface
     * 
     * @var $custom
     */
    protected $custom;

    /**
     * 
     * @param CustomInterface $custom
     */
    public function __construct(CustomInterface $custom)
    {
        $this->custom = $custom;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $retrievedCustoms = $this->custom->all();

        if (!count($retrievedCustoms)) {
            return ApiResponse::responseError('The table is empty.', 422);
        }

        return ApiResponse::responseOk('Customs list.', $retrievedCustoms);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCustomRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->custom->store($postValues);

        return ApiResponse::responseOk('Custom was added successfully.', $this->custom->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCustomRequest $request, $id)
    {
        $this->custom->update($id, $request->all());

        return ApiResponse::responseOk('Custom was updated successfully.', $this->custom->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedCustom = $this->custom->find($id);

        if (empty($retrievedCustom)) {
            return ApiResponse::responseError('Custom not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved Custom by id.', $retrievedCustom);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return ApiResponse::responseOk('Custom was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedCustom = $this->custom->destroy($id);

        if (empty($deletedCustom)) {
            return ApiResponse::responseError('Custom not found.', 422);
        }

        return ApiResponse::responseOk('Custom was deleted successfully.', $this->custom->all());
    }
}
