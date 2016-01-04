<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreDeviceRequest;
use DentalSleepSolutions\Http\Requests\UpdateDeviceRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\DeviceInterface;

class ApiDeviceController extends ApiBaseController
{
    /**
     * References the device interface
     * 
     * @var $device
     */
    protected $device;

    /**
     * 
     * @param DeviceInterface $device
     */
    public function __construct(DeviceInterface $device)
    {
        $this->device = $device;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $devices = $this->device->all();

        if (!count($devices)) {
            return ApiResponse::responseOk('The list is empty', $devices);
        }

        return ApiResponse::responseOk('Devices list', $devices);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDeviceRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->device->store($postValues);

        return ApiResponse::responseOk('Device was added successfully.', $this->device->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDeviceRequest $request, $id)
    {
        $this->device->update($id, $request->all());

        return ApiResponse::responseOk('Device was updated successfully.', $this->device->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedDevice = $this->device->find($id);

        if (empty($retrievedDevice)) {
            return ApiResponse::responseError('Device not found.', 404);
        }

        return ApiResponse::responseOk('Retrieved device by id.', $retrievedDevice);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return ApiResponse::responseOk('Device was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedDevice = $this->device->destroy($id);

        if (empty($deletedDevice)) {
            return ApiResponse::responseError('Device not found.', 404);
        }

        return ApiResponse::responseOk('Device was deleted successfully.', $this->device->all());
    }
}
