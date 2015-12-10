<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreChargeRequest;
use DentalSleepSolutions\Http\Requests\UpdateChargeRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;
use DentalSleepSolutions\Interfaces\Repositories\ChargeInterface;

class ApiChargeController extends ApiBaseController
{
    /**
     * References the charge interface
     * 
     * @var $charge
     */
    protected $charge;

    /**
     * 
     * @param ChargeInterface $charge 
     */
    public function __construct(ChargeInterface $charge)
    {
        $this->charge = $charge;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $retrievedCharges = $this->charge->all();

        if (!count($retrievedCharges)) {
            return ApiResponse::responseError('The table is empty.', 422);
        }

        return ApiResponse::responseOk('Charges list.', $retrievedCharges);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreChargeRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->charge->store($postValues);

        return ApiResponse::responseOk('Charge was added successfully.', $this->charge->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateChargeRequest $request, $id)
    {
        $this->charge->update($id, $request->all());

        return ApiResponse::responseOk('Charge was updated successfully.', $this->charge->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedCharge = $this->charge->find($id);

        if (empty($retrievedCharge)) {
            return ApiResponse::responseError('Charge not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved charge by id.', $retrievedCharge);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return ApiResponse::responseOk('Charge was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedCharge = $this->charge->destroy($id);

        if (empty($deletedCharge)) {
            return ApiResponse::responseError('Charge not found.', 422);
        }

        return ApiResponse::responseOk('Charge was deleted successfully.', $this->charge->all());
    }
}
