<?php

namespace DentalSleepSolutions\Http\Controllers\Patient;

use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalPatientRepository;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Controllers\ExternalBaseController;
use DentalSleepSolutions\Http\Requests\Patient\ExternalPatientStore;
use EventHomes\Api\FractalHelper;
use DentalSleepSolutions\Http\Transformers\ExternalPatient as Transformer;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class ExternalPatientController extends ExternalBaseController
{
    use FractalHelper;

    /**
     * Display the specified resource.
     *
     * @param ExternalPatientRepository $repository
     * @param \DentalSleepSolutions\Http\Requests\Patient\ExternalPatientStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ExternalPatientRepository $repository, ExternalPatientStore $request) {
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

        $externalPatient = $repository->findByExternalCompanyAndPatient($externalCompanyId, $externalPatientId);

        if (!$externalPatient) {
            $externalPatient = $repository->create($externalPatientData);
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
