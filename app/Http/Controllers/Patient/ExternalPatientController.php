<?php

namespace DentalSleepSolutions\Http\Controllers\Patient;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Controllers\ExternalBaseController;
use DentalSleepSolutions\Http\Requests\Patient\ExternalPatientStore;
use DentalSleepSolutions\Contracts\Repositories\ExternalPatients;
use EventHomes\Api\FractalHelper;
use DentalSleepSolutions\Http\Transformers\ExternalPatient as Transformer;
use Carbon\Carbon;
use Illuminate\Support\Arr;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class ExternalPatientController extends ExternalBaseController
{
    use FractalHelper;

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ExternalPatients $resources
     * @param  \DentalSleepSolutions\Http\Requests\Patient\ExternalPatientStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ExternalPatients $resources, ExternalPatientStore $request) {
        $transformer = new Transformer;
        $data = $transformer->fromTransform($request->all());

        $created = false;

        $patientData = Arr::get($data, 'patient');
        $externalPatientData = Arr::get($data, 'external_patient');
        $externalCompanyId = Arr::get($externalPatientData, 'software');
        $externalPatientId = Arr::get($externalPatientData, 'external_id');

        /**
         * Concatenate patient address
         */
        if (isset($patientData['p_m_address'])) {
            $address = $patientData['p_m_address'] . ' ' . Arr::get($patientData, 'p_m_address2');
            $patientData['p_m_address'] = trim($address);
            unset($patientData['p_m_address2']);
        }

        $externalPatient = $resources
            ->where('software', $externalCompanyId)
            ->where('external_id', $externalPatientId)
            ->first();

        if (!$externalPatient) {
            $externalPatient = $resources->create($externalPatientData);
        } else {
            $externalPatient->update($externalPatientData);
            $externalPatient->update(['dirty' => 1]);
        }

        $externalPatient->update($patientData);
        $patient = $externalPatient->patient()->first();

        if (!$patient) {
            $updateData = [
                'docid' => $this->currentUser->docid,
                'status' => 3, // Pending Active
                'ip_address' => $request->ip(),
                'adddate' => Carbon::now(),
            ];

            $patient = $externalPatient->patient()->create($patientData);
            $patient->update($updateData);

            $created = true;
        }

        if ($externalPatient->wasRecentlyCreated || $patient->wasRecentlyCreated) {
            $externalPatient->update([
                'software' => $externalCompanyId,
                'external_id' => $externalPatientId,
                'patient_id' => $patient->getKey(),
            ]);

            $created = true;
        }

        $redirectUrl = env('FRONTEND_URL') . 'manage/external-patient.php?' .
            http_build_query([
                'sw' => Arr::get($data, 'external_patient.software'),
                'id' => Arr::get($data, 'external_patient.external_id'),
            ]);

        return ApiResponse::responseOk(
            '',
            ['redirect_url' => $redirectUrl],
            $created ? 201 : 200
        );
    }
}
