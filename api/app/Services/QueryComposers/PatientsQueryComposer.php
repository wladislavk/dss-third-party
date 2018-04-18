<?php

namespace DentalSleepSolutions\Services\QueryComposers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Structs\PatientFinderData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;

class PatientsQueryComposer
{
    const TYPES_TO_STATUSES = [
        1 => 1,
        2 => [1, 2],
        3 => 2,
    ];

    /** @var PatientRepository */
    private $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    /**
     * @param string $selections
     * @param string $tables
     * @param string $orderBy
     * @param array $patientIds
     * @param PatientFinderData $data
     * @return array|Collection
     */
    public function composeFindPatientQuery(
        $selections,
        $tables,
        $orderBy,
        array $patientIds,
        PatientFinderData $data
    ) {
        $query = $this->patientRepository->getFindPatientBaseQuery($selections, $tables);
        $query = $this->getPatientQueriesConditions($query, $data, $patientIds);
        $query = $this->patientRepository->paginateFindPatientQuery(
            $query, $orderBy, $data->patientsPerPage
        );
        return $query->get();
    }

    /**
     * @param string $tables
     * @param PatientFinderData $patientFinderData
     * @return array|Collection
     */
    public function composeFindPatientCountQuery(
        $tables,
        PatientFinderData $patientFinderData
    ) {
        $query = $this->patientRepository->getFindPatientCountBaseQuery($tables);
        $query = $this->getPatientQueriesConditions($query, $patientFinderData);
        return $query->get();
    }

    /**
     * @param string $selections
     * @param string $tables
     * @param string $orderBy
     * @param PatientFinderData $data
     * @return array|Collection
     */
    public function composeFindPatientOrderQuery(
        $selections,
        $tables,
        $orderBy,
        PatientFinderData $data
    ) {
        $query = $this->patientRepository->getFindPatientOrderBaseQuery($selections, $tables);
        $query = $this->getPatientQueriesConditions($query, $data);

        $offset = $data->pageNumber * $data->patientsPerPage;
        $query = $this->patientRepository->paginateFindPatientOrderQuery(
            $query, $orderBy, $offset, $data->patientsPerPage
        );
        return $query->get();
    }

    /**
     * @param Builder|QueryBuilder $query
     * @param PatientFinderData $patientFinderData
     * @param array $patientIds
     * @return Builder|QueryBuilder
     */
    private function getPatientQueriesConditions(
        $query,
        PatientFinderData $patientFinderData,
        array $patientIds = []
    ) {
        $query = $this->patientRepository->addDocIdToFindPatientQuery($query, $patientFinderData->docId);

        $query = $this->addPatientIdConditions($query, $patientFinderData, $patientIds);

        if (array_key_exists($patientFinderData->type, self::TYPES_TO_STATUSES)) {
            $query = $this->addStatusConditions($query, $patientFinderData->type);
        }

        if ($patientFinderData->letter) {
            $query = $this->patientRepository->addLastNameToFindPatientQuery($query, $patientFinderData->letter . '%');
        }

        return $query;
    }

    /**
     * @param Builder|QueryBuilder $query
     * @param PatientFinderData $patientFinderData
     * @param array $patientIds
     * @return Builder|QueryBuilder
     */
    private function addPatientIdConditions(
        $query,
        PatientFinderData $patientFinderData,
        array $patientIds
    ) {
        if ($patientFinderData->patientId) {
            return $this->patientRepository->addPatientIdToFindPatientQuery($query, $patientFinderData->patientId);
        }
        if (count($patientIds)) {
            return $this->patientRepository->addPatientIdsArrayToFindPatientQuery($query, $patientIds);
        }
        return $query;
    }

    /**
     * @param Builder|QueryBuilder $query
     * @param int $type
     * @return Builder|QueryBuilder
     */
    private function addStatusConditions($query, $type)
    {
        $status = self::TYPES_TO_STATUSES[$type];
        if (is_array($status)) {
            return $this->patientRepository->addSeveralStatusesToFindPatientQuery($query, $status);
        }
        return $this->patientRepository->addStatusToFindPatientQuery($query, $status);
    }
}
