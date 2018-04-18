<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Http\Transformers\ExternalPatient as Transformer;
use Illuminate\Support\Arr;

// @todo: this class must be completely rewritten, transformer is untested and therefore should be merged here
class ExternalPatientDataRetriever
{
    const EXTERNAL_PATIENT_EXCLUDED_INDEXES = [
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
    ];

    /** @var Transformer */
    private $transformer;

    /**
     * ExternalPatientDataRetriever constructor.
     * @param Transformer $transformer
     */
    public function __construct(Transformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param array $fromRequest
     * @return array
     */
    public function toExternalPatientData(array $fromRequest)
    {
        $externalPatientData = $this->transformer->inverseTransform($fromRequest);
        return $externalPatientData;
    }

    /**
     * @param array $fromRequest
     * @return array
     */
    public function toPatientData(array $fromRequest)
    {
        $externalPatientData = $this->transformer->inverseTransform($fromRequest);
        $patientData = Arr::except($externalPatientData, self::EXTERNAL_PATIENT_EXCLUDED_INDEXES);
        return $patientData;
    }
}
