<?php

namespace DentalSleepSolutions\Http\Controllers;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalPatientRepository;
use DentalSleepSolutions\Http\Requests\Patient\ExternalPatientStore;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Http\Transformers\ExternalPatient as Transformer;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use EventHomes\Api\FractalHelper;
use Illuminate\Config\Repository as Config;
use Illuminate\Support\Arr;

class ExternalPatientsController extends Controller
{
    use FractalHelper;

    /** @var Transformer */
    private $transformer;

    public function __construct(
        Config $config,
        Request $request,
        Transformer $transformer
    )
    {
        parent::__construct($config, $request);
        $this->transformer = $transformer;
    }

    /**
     * @param ExternalPatientRepository $repository
     * @param ExternalPatientStore      $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(
        ExternalPatientRepository $repository,
        ExternalPatientStore $request
    )
    {
        $externalPatientData = $this->transformer->inverseTransform($request->all());
        $patientData = Arr::except($externalPatientData, [
            'software',
            'external_id',
            'patient_id',
            'dirty',
            'payer_name',
            'payer_address1',
            'payer_address2',
            'payer_city',
            'payer_state',
            'payer_zip',
            'payer_phone',
            'payer_fax',
            'subscriber_phone',
            'dependent_phone',
        ]);
        $externalCompanyId = Arr::get($externalPatientData, 'software', '');
        $externalPatientId = Arr::get($externalPatientData, 'external_id', '');

        /**
         * Concatenate patient address
         */
        if (isset($externalPatientData['p_m_address'])) {
            $address = $externalPatientData['p_m_address'] . ' ' . Arr::get($externalPatientData, 'p_m_address2');
            $address = trim($address);
            $externalPatientData['p_m_address'] = $address;
            $patientData['p_m_address'] = $address;
            unset($externalPatientData['p_m_address2']);
            unset($patientData['p_m_address2']);
        }

        $externalPatient = $repository->findByExternalCompanyAndPatient($externalCompanyId, $externalPatientId);

        if ($externalPatient) {
            $externalPatient->update($externalPatientData);
            $externalPatient->update(['dirty' => 1]);
        }

        if (!$externalPatient) {
            $externalPatient = $repository->create($externalPatientData);
        }

        $externalPatient->update($patientData);
        $patient = $externalPatient->patient()
            ->first()
        ;

        $created = false;

        if (!$patient) {
            $updateData = [
                'docid' => $this->user->userid,
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
                'sw' => Arr::get($externalPatientData, 'software'),
                'id' => Arr::get($externalPatientData, 'external_id'),
            ])
        ]);

        $httpStatus = 200;

        if ($created) {
            $httpStatus = 201;
        }

        return ApiResponse::responseOk('', ['redirect_url' => $redirectUrl], $httpStatus);
    }
}
