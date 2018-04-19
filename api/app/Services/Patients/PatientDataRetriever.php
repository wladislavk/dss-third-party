<?php

namespace DentalSleepSolutions\Services\Patients;

use DentalSleepSolutions\Eloquent\Models\Dental\HealthHistory;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\HealthHistoryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\HomeSleepTestRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\InsuranceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientContactRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientInsuranceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Factories\RepositoryFactory;
use DentalSleepSolutions\Structs\PatientData;
use DentalSleepSolutions\Structs\QuestionnaireData;
use Illuminate\Database\Eloquent\Collection;

class PatientDataRetriever
{
    /** @var HealthHistoryRepository */
    private $healthHistoryRepository;

    /** @var HomeSleepTestRepository */
    private $homeSleepTestRepository;

    /** @var InsuranceRepository */
    private $insuranceRepository;

    /** @var PatientRepository */
    private $patientRepository;

    /** @var PatientContactRepository */
    private $patientContactRepository;

    /** @var PatientInsuranceRepository */
    private $patientInsuranceRepository;

    public function __construct(RepositoryFactory $repositoryFactory)
    {
        $this->healthHistoryRepository = $repositoryFactory->getRepository(HealthHistoryRepository::class);
        $this->homeSleepTestRepository = $repositoryFactory->getRepository(HomeSleepTestRepository::class);
        $this->insuranceRepository = $repositoryFactory->getRepository(InsuranceRepository::class);
        $this->patientRepository = $repositoryFactory->getRepository(PatientRepository::class);
        $this->patientContactRepository = $repositoryFactory->getRepository(PatientContactRepository::class);
        $this->patientInsuranceRepository = $repositoryFactory->getRepository(PatientInsuranceRepository::class);
    }

    /**
     * @param int $docId
     * @param Patient $patient
     * @return PatientData
     */
    public function getPatientData($docId, Patient $patient)
    {
        $questionnaireData = new QuestionnaireData();
        $patientData = new PatientData();
        $patientData->populatePlainFields($patient);
        $patientContacts = $this->patientContactRepository->getCurrent($docId, $patient->patientid);
        $patientData->patientContactsNumber = sizeof($patientContacts);
        $patientInsurances = $this->patientInsuranceRepository->getCurrent($docId, $patient->patientid);
        $patientData->patientInsurancesNumber = sizeof($patientInsurances);
        $patientData->rejectedClaims = $this->insuranceRepository->getRejected($patient->patientid);
        $questionnaireData->historyStatus = $patient->history_status;
        $questionnaireData->treatmentsStatus = $patient->treatments_status;
        $questionnaireData->symptomsStatus = $patient->symptoms_status;
        $patientData->questionnaireData = $questionnaireData;
        $patientData->isEmailBounced = boolval($patient->email_bounce);
        $children = $this->patientRepository->getNumberByPatient($patient->patientid)->toArray();
        if (isset($children['total'])) {
            $patientData->subPatientsNumber = $children['total'];
        }
        /** @var HealthHistory[]|Collection $healthHistories */
        $healthHistories = $this->healthHistoryRepository->findByField('patientid', $patient->patientid);
        if (isset($healthHistories[0])) {
            $healthHistory = $healthHistories[0];
            $patientData->otherAllergens = $healthHistory->other_allergens;
            $patientData->hasAllergen = boolval($healthHistory->allergenscheck);
        }
        $incompleteHSTs = $this->homeSleepTestRepository->getIncomplete($patient->patientid);
        $patientData->incompleteHomeSleepTests = $incompleteHSTs;
        if (sizeof($incompleteHSTs)) {
            $lastHst = $incompleteHSTs[sizeof($incompleteHSTs) - 1];
            $patientData->homeSleepTestStatus = intval($lastHst->status);
        }
        return $patientData;
    }
}
