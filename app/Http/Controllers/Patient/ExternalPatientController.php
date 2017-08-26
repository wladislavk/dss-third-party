<?php

namespace DentalSleepSolutions\Http\Controllers\Patient;

use DentalSleepSolutions\Helpers\ExternalAuthTokenParser;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalPatientRepository;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Http\Controllers\ExternalBaseController;
use DentalSleepSolutions\Http\Requests\Patient\ExternalPatientStore;
use EventHomes\Api\FractalHelper;
use DentalSleepSolutions\Http\Transformers\ExternalPatient as Transformer;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class ExternalPatientController extends ExternalBaseController
{
    use FractalHelper;

    /** @var Transformer */
    private $transformer;

    public function __construct(
        Config $config,
        ExternalAuthTokenParser $authTokenParser,
        Request $request,
        Transformer $transformer
    )
    {
        parent::__construct($config, $authTokenParser, $request);
        $this->transformer = $transformer;
    }

    /**
     * @param \DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalPatientRepository $repository
     * @param \DentalSleepSolutions\Http\Requests\Patient\ExternalPatientStore             $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ExternalPatientRepository $repository, ExternalPatientStore $request) {
        $data = $this->transformer->inverseTransform($request->all());

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

        $redirectUrl = join('', [
            $this->config->get('app.external_patient.frontend_url'),
            $this->config->get('app.external_patient.redirect_uri'),
            '?',
            http_build_query([
                'sw' => Arr::get($data, 'external_patient.software'),
                'id' => Arr::get($data, 'external_patient.external_id'),
            ])
        ]);

        $httpStatus = 200;

        if ($created) {
            $httpStatus = 201;
        }

        return ApiResponse::responseOk('', ['redirect_url' => $redirectUrl], $httpStatus);
    }
}
