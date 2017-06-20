<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Resources\Insurance;
use DentalSleepSolutions\Contracts\Resources\Ledger;
use DentalSleepSolutions\Contracts\Repositories\Insurances;
use Illuminate\Http\Request;

class InsurancesController extends BaseRestController
{
    const DSS_USER_TYPE_FRANCHISEE = 1;
    const DSS_USER_TYPE_SOFTWARE   = 2;

    // Transaction statuses (ledger)
    const DSS_TRXN_NA = 0; // trxn created/updated, but not filed.

    public function index()
    {
        return parent::index();
    }

    public function show($id)
    {
        return parent::show($id);
    }

    public function store()
    {
        return parent::store();
    }

    public function update($id)
    {
        return parent::update($id);
    }

    public function destroy($id)
    {
        return parent::destroy($id);
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
        $claimId = $request->input('claim_id', 0);

        $isSuccess = $resource->removePendingClaim($claimId);

        if ($isSuccess) {
            $ledgerResource->updateWherePrimaryClaimId($claimId, [
                'primary_claim_id' => null,
                'status'           => self::DSS_TRXN_NA,
            ]);

            return ApiResponse::responseOk('Deleted Successfully');
        } else {
            return ApiResponse::responseError('Error deleting');
        }
    }
}
