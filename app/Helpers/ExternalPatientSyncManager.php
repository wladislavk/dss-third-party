<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalPatient;
use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalPatientRepository;
use Illuminate\Support\Arr;

class ExternalPatientSyncManager
{
    const EXTERNAL_COMPANY_KEY = 'software';
    const EXTERNAL_PATIENT_KEY = 'external_id';
    const MODEL_KEY = 'patient_id';
    const MODEL_DIRTY_KEY = 'dirty';

    /** @var ExternalPatientRepository */
    private $repository;

    /** @var ExternalPatientDataRetriever */
    private $dataRetriever;

    public function __construct(
        ExternalPatientRepository $repository,
        ExternalPatientDataRetriever $dataRetriever
    )
    {
        $this->repository = $repository;
        $this->dataRetriever = $dataRetriever;
    }

    /**
     * @param array $requestData
     * @param array $createAttributes
     * @return ExternalPatient
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updateOnMissingCreate(array $requestData, array $createAttributes)
    {
        $externalPatientData = $this->dataRetriever->toExternalPatientData($requestData);
        $patientData = $this->dataRetriever->toPatientData($requestData);

        $externalCompanyId = Arr::get($externalPatientData, self::EXTERNAL_COMPANY_KEY, '');
        $externalPatientId = Arr::get($externalPatientData, self::EXTERNAL_PATIENT_KEY, '');

        $externalPatient = $this->findByExternalCompanyAndPatient(
            $externalCompanyId, $externalPatientId, $externalPatientData, $patientData
        );
        $patient = $this->getLinkedPatient($externalPatient, $patientData, $createAttributes);

        if ($externalPatient->wasRecentlyCreated || $patient->wasRecentlyCreated) {
            $externalPatient->update([
                self::EXTERNAL_COMPANY_KEY=> $externalCompanyId,
                self::EXTERNAL_PATIENT_KEY=> $externalPatientId,
                self::MODEL_KEY => $patient->getKey(),
            ]);
            $externalPatient->wasRecentlyCreated = true;
        }

        return $externalPatient;
    }

    /**
     * @param string $externalCompanyId
     * @param string $externalPatientId
     * @param array  $externalPatientData
     * @param array  $patientData
     * @return ExternalPatient
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    private function findByExternalCompanyAndPatient(
        $externalCompanyId,
        $externalPatientId,
        array $externalPatientData,
        array $patientData
    )
    {
        $externalPatient = $this->repository
            ->findByExternalCompanyAndPatient($externalCompanyId, $externalPatientId)
        ;

        if ($externalPatient) {
            $externalPatient->update($externalPatientData);
            $externalPatient->update($patientData);
            $externalPatient->update([
                self::MODEL_DIRTY_KEY => 1,
            ]);
            return $externalPatient;
        }

        $externalPatient = $this->repository
            ->create($externalPatientData)
        ;
        $externalPatient->update($patientData);
        return $externalPatient;
    }

    /**
     * @param ExternalPatient $externalPatient
     * @param array           $patientData
     * @param array           $createAttributes
     * @return Model
     */
    private function getLinkedPatient(
        ExternalPatient $externalPatient,
        array $patientData,
        array $createAttributes
    )
    {
        $patient = $externalPatient->patient()
            ->getResults()
        ;

        if ($patient) {
            return $patient;
        }

        $patient = $externalPatient->patient()
            ->create($patientData)
        ;
        $patient->update($createAttributes);
        return $patient;
    }
}
