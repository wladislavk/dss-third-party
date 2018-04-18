<?php

namespace DentalSleepSolutions\Http\Controllers;

use Carbon\Carbon;
use DentalSleepSolutions\Helpers\ExternalPatientSyncManager;
use DentalSleepSolutions\Http\Requests\Patient\ExternalPatientStore;
use DentalSleepSolutions\Facades\ApiResponse;
use Illuminate\Http\JsonResponse;
use Prettus\Validator\Exceptions\ValidatorException;

class ExternalPatientsController extends Controller
{
    const DSS_PATIENT_STATUS_PENDING_ACTIVE = 3;

    /**
     * @param ExternalPatientStore $request
     * @param ExternalPatientSyncManager $syncManager
     * @return JsonResponse
     * @throws ValidatorException
     */
    public function store(
        ExternalPatientStore $request,
        ExternalPatientSyncManager $syncManager
    ): JsonResponse {
        $requestData = $request->all();
        $createAttributes = [
            'docid' => $this->user->docid,
            'status' => self::DSS_PATIENT_STATUS_PENDING_ACTIVE,
            'ip_address' => $request->ip(),
            'adddate' => Carbon::now(),
        ];
        $externalPatient = $syncManager->updateOnMissingCreate($requestData, $createAttributes);

        $redirectUrl = join('', [
            $this->config->get('app.external_patient.frontend_url'),
            $this->config->get('app.external_patient.redirect_uri'),
            '?',
            http_build_query([
                'sw' => $externalPatient->software,
                'id' => $externalPatient->external_id,
            ])
        ]);
        $httpStatus = 200;
        if ($externalPatient->wasRecentlyCreated) {
            $httpStatus = 201;
        }

        return ApiResponse::responseOk('', ['redirect_url' => $redirectUrl], $httpStatus);
    }
}
