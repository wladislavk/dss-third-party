<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreClaimElectronicRequest;
use DentalSleepSolutions\Http\Requests\UpdateClaimElectronicRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\ClaimElectronicInterface;

class ApiClaimElectronicController extends ApiBaseController
{
    /**
     * References the claim electronic interface
     * 
     * @var $claimElectronic
     */
    protected $claimElectronic;

    /**
     * 
     * @param ClaimElectronicInterface $claimElectronic 
     */
    public function __construct(ClaimElectronicInterface $claimElectronic)
    {
        $this->claimElectronic = $claimElectronic;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $retrievedClaimsElectronic = $this->claimElectronic->all();

        if (!count($retrievedClaimsElectronic)) {
            return ApiResponse::responseError('The table is empty.', 422);
        }

        return ApiResponse::responseOk('Claims electronic list.', $retrievedClaimsElectronic);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreClaimElectronicRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->claimElectronic->store($postValues);

        return ApiResponse::responseOk('Claim electronic was added successfully.', $this->claimElectronic->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateClaimElectronicRequest $request, $id)
    {
        $this->claimElectronic->update($id, $request->all());

        return ApiResponse::responseOk('Claim electronic was updated successfully.', $this->claimElectronic->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedClaimsElectronic = $this->claimElectronic->find($id);

        if (empty($retrievedClaimsElectronic)) {
            return ApiResponse::responseError('Claim electronic not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved claim electronic by id.', $retrievedClaimsElectronic);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return ApiResponse::responseOk('Claim electronic was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedClaimElectronic = $this->claimElectronic->destroy($id);

        if (empty($deletedClaimElectronic)) {
            return ApiResponse::responseError('Claim electronic not found.', 422);
        }

        return ApiResponse::responseOk('Claim electronic was deleted successfully.', $this->claimElectronic->all());
    }
}
