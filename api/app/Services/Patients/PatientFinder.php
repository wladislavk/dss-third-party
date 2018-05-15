<?php

namespace DentalSleepSolutions\Services\Patients;

use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Eloquent\Repositories\Factories\FindPatientQuerySectionFactory;
use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\AbstractSection;
use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\VOBSection;
use DentalSleepSolutions\Structs\PatientFinderData;
use Illuminate\Database\Eloquent\Collection;

// @todo: this class needs further refactoring, SQL lines should not be present outside of repositories
class PatientFinder
{
    const COLUMN_WILDCARD = '%COLUMN%';

    /** @var PatientsQueryComposer */
    private $patientsQueryComposer;

    /** @var FindPatientQuerySectionFactory */
    private $findPatientQuerySectionFactory;

    public function __construct(
        PatientsQueryComposer $patientsQueryComposer,
        FindPatientQuerySectionFactory $findPatientQuerySectionFactory
    ) {
        $this->patientsQueryComposer = $patientsQueryComposer;
        $this->findPatientQuerySectionFactory = $findPatientQuerySectionFactory;
    }

    /**
     * @param PatientFinderData $data
     * @return array
     * @throws \DentalSleepSolutions\Exceptions\RepositoryFactoryException
     */
    public function findPatientBy(PatientFinderData $data) {
        $section = $this->findPatientQuerySectionFactory->getQuerySection($data->sortColumn);

        $orderBy = '';
        if ($section && $section->getOrderSQL($data->sortDir)) {
            $orderBy = $section->getOrderSQL($data->sortDir);
        }

        $selections = $this->getSelections($data, $section);

        $tableList = [PatientRepository::BASE_FIND_PATIENT_TABLE];
        $vobSectionClass = new VOBSection();
        $tableList[] = $vobSectionClass->getJoinSQL();

        if ($section && $section->getJoinSQL()) {
            $tableList[] = $section->getJoinSQL();
        }
        $tableList = array_unique($tableList);
        $tables = join(' ', array_filter($tableList));

        $countResult = $this->patientsQueryComposer
            ->composeFindPatientCountQuery($tables, $data);

        $orderResult = $this->patientsQueryComposer
            ->composeFindPatientOrderQuery($selections, $tables, $orderBy, $data);
        ;

        $result = $this->doMainQuery($data, $orderResult, $orderBy);

        return [
            'count'   => $countResult,
            'order'   => $orderResult,
            'results' => $result,
        ];
    }

    /**
     * @param PatientFinderData $data
     * @param AbstractSection $section
     * @return string
     */
    private function getSelections(
        PatientFinderData $data,
        AbstractSection $section
    ) {
        $selectList = PatientRepository::BASE_FIND_PATIENT_SELECT;
        if ($section && $section->getSelectSQL()) {
            $select = $this->addUserTypeToSelect($data, $section);
            $selectList[] = $select;
        }
        return join(', ', array_filter($selectList));
    }

    /**
     * @todo: This query will be extremely heavy and slow, need to refactor
     *
     * @param PatientFinderData $data
     * @param array|Collection $orderResult
     * @param string $orderBy
     * @return array|Collection
     */
    private function doMainQuery(
        PatientFinderData $data,
        $orderResult,
        $orderBy
    ) {
        $mainQuerySelectList = PatientRepository::BASE_FIND_PATIENT_SELECT;
        $mainQueryTableList = [PatientRepository::BASE_FIND_PATIENT_TABLE];
        foreach ($this->findPatientQuerySectionFactory->getAllSections() as $someSection) {
            $mainQuerySelectList[] = $this->addUserTypeToSelect($data, $someSection);
            $mainQueryTableList[] = $someSection->getJoinSQL();
        }
        $mainQuerySelectList[] = PatientRepository::ALL_FIELDS_SELECT;
        $mainQueryTableList = array_unique($mainQueryTableList);
        $mainQuerySelections = join(', ', array_filter($mainQuerySelectList));
        $mainQueryTables = join(' ', array_filter($mainQueryTableList));

        $patientIds = [];
        if (count($orderResult)) {
            $patientIds = array_pluck($orderResult, 'patientid');
        }

        return $this->patientsQueryComposer->composeFindPatientQuery(
            $mainQuerySelections, $mainQueryTables, $orderBy, $patientIds, $data
        );
    }

    /**
     * @param PatientFinderData $data
     * @param AbstractSection $section
     * @return string
     */
    private function addUserTypeToSelect(PatientFinderData $data, AbstractSection $section)
    {
        return str_replace(self::COLUMN_WILDCARD, $data->userType, $section->getSelectSQL());
    }
}
