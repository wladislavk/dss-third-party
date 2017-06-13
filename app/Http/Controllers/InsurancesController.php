<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Requests\InsuranceStore;
use DentalSleepSolutions\Http\Requests\InsuranceUpdate;
use DentalSleepSolutions\Http\Requests\InsuranceDestroy;
use DentalSleepSolutions\Contracts\Resources\Insurance;
use DentalSleepSolutions\Contracts\Resources\Ledger;
use DentalSleepSolutions\Contracts\Repositories\Insurances;
use Illuminate\Http\Request;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class InsurancesController extends Controller
{
    const DSS_USER_TYPE_FRANCHISEE = 1;
    const DSS_USER_TYPE_SOFTWARE   = 2;

    // Transaction statuses (ledger)
    const DSS_TRXN_NA = 0; // trxn created/updated, but not filed.

    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Insurances $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Insurances $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Insurance $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Insurance $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Insurances $resources
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Insurances $resources, InsuranceStore $request)
    {
        $data = array_merge($request->all(), [
            'ip_address' => $request->ip()
        ]);

        $resource = $resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Insurance $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Insurance $resource, InsuranceUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Insurance $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Insurance $resource, InsuranceDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    public function getRejected(Insurances $resources, Request $request)
    {
        $patientId = $request->input('patientId');

        $data = $resources->getRejected($patientId);

        return ApiResponse::responseOk('', $data);
    }

    public function getFrontOfficeClaims($type, Insurances $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $isUserTypeSoftware = ($this->currentUser->user_type == self::DSS_USER_TYPE_SOFTWARE);

        switch ($type) {
            case 'pending-claims':
                $data = $resources->getPendingClaims($docId);
                break;
            case 'unmailed-claims':
                $data = $resources->getUnmailedClaims($docId, $isUserTypeSoftware);
                break;
            case 'rejected-claims':
                $data = $resources->getRejectedClaims($docId);
                break;
            default:
                $data = [];
                break;
        }

        return ApiResponse::responseOk('', $data);
    }

    public function removeClaim(Insurance $resource, Ledger $ledgerResource, Request $request)
    {
        $claimId = $request->input('claim_id') ?: 0;

        $isSuccess = $resource->removePendingClaim($claimId);

        if ($isSuccess) {
            $ledgerResource->updateWherePrimaryClaimId($claimId, [
                'primary_claim_id' => null,
                'status'           => self::DSS_TRXN_NA
            ]);

            return ApiResponse::responseOk('Deleted Successfully');
        } else {
            return ApiResponse::responseError('Error deleting');
        }
    }
}
