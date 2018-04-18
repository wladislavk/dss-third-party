<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalPatient;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalPatientRepository;
use Prettus\Validator\Exceptions\ValidatorException;

// @todo: this class must be completely rewritten, as it is unsafe (user input not filtered) and practically untestable
class ExternalPatientSyncManager
{
    const MODEL_DIRTY_KEY = 'dirty';

    const NON_NULLABLE_PATIENT_FIELDS = [
        'member_no',
        'group_no',
        'plan_no',
        'p_m_partymname',
        'p_m_partylname',
        's_m_partymname',
        's_m_partylname',
        'p_m_ins_grp',
        's_m_ins_grp',
        'p_m_ins_plan',
        's_m_ins_plan',
        'p_m_dss_file',
        's_m_dss_file',
        'p_m_ins_type',
        's_m_ins_type',
        'p_m_ins_ass',
        's_m_ins_ass',
        'ins_dob',
        'ins2_dob',
        'premed',
        'docsleep',
        'docpcp',
        'docdentist',
        'docent',
        'docmdother',
        'docmdother2',
        'docmdother3',
    ];

    /** @var ExternalPatientRepository */
    private $repository;

    /** @var ExternalPatientDataRetriever */
    private $dataRetriever;

    public function __construct(
        ExternalPatientRepository $repository,
        ExternalPatientDataRetriever $dataRetriever
    ) {
        $this->repository = $repository;
        $this->dataRetriever = $dataRetriever;
    }

    /**
     * @param array $requestData
     * @param array $createAttributes
     * @return ExternalPatient
     * @throws ValidatorException
     */
    public function updateOnMissingCreate(array $requestData, array $createAttributes)
    {
        $externalPatientData = $this->dataRetriever->toExternalPatientData($requestData);
        $patientData = $this->dataRetriever->toPatientData($requestData);

        $externalCompanyId = '';
        if (isset($externalPatientData['software'])) {
            $externalCompanyId = $externalPatientData['software'];
        }
        $externalPatientId = '';
        if (isset($externalPatientData['external_id'])) {
            $externalPatientId = $externalPatientData['external_id'];
        }

        $externalPatient = $this->findByExternalCompanyAndPatient(
            $externalCompanyId, $externalPatientId, $externalPatientData, $patientData
        );
        $patient = $this->getLinkedPatient($externalPatient, $patientData, $createAttributes);

        if ($externalPatient->wasRecentlyCreated || $patient->wasRecentlyCreated) {
            $externalPatient->update([
                'software' => $externalCompanyId,
                'external_id' => $externalPatientId,
                'patient_id' => $patient->getKey(),
            ]);
            $externalPatient->wasRecentlyCreated = true;
        }

        return $externalPatient;
    }

    /**
     * @param string $externalCompanyId
     * @param string $externalPatientId
     * @param array $externalPatientData
     * @param array $patientData
     * @return ExternalPatient
     * @throws ValidatorException
     */
    private function findByExternalCompanyAndPatient(
        string $externalCompanyId,
        string $externalPatientId,
        array $externalPatientData,
        array $patientData
    ): ExternalPatient {
        $externalPatient = $this->repository->findByExternalCompanyAndPatient($externalCompanyId, $externalPatientId);

        if ($externalPatient) {
            $externalPatient->update($externalPatientData);
            $externalPatient->update($patientData);
            $externalPatient->update([
                self::MODEL_DIRTY_KEY => 1,
            ]);
            return $externalPatient;
        }

        $externalPatient = $this->repository->create($externalPatientData);
        $externalPatient->update($patientData);
        return $externalPatient;
    }

    /**
     * @param ExternalPatient $externalPatient
     * @param array $patientData
     * @param array $createAttributes
     * @return Patient
     */
    private function getLinkedPatient(
        ExternalPatient $externalPatient,
        array $patientData,
        array $createAttributes
    ): Patient {
        $patient = $externalPatient->patient()->getResults();

        if ($patient) {
            return $patient;
        }

        foreach (self::NON_NULLABLE_PATIENT_FIELDS as $field) {
            if (!array_key_exists($field, $patientData) || is_null($patientData[$field])) {
                $patientData[$field] = '';
            }
            if (array_key_exists($field, $createAttributes) && is_null($createAttributes[$field])) {
                $createAttributes[$field] = '';
            }
        }

        /** @var Patient $patient */
        $patient = $externalPatient->patient()->create($patientData);
        $patient->update($createAttributes);
        return $patient;
    }
}
