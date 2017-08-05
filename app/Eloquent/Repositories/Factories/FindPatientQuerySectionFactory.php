<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Factories;

use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\AbstractSection;
use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\AllergensCheckSection;
use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\ApplianceSection;
use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\ApplianceSinceSection;
use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\LastTreatmentSection;
use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\LastVisitSection;
use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\LedgerSection;
use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\NameSection;
use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\NextVisitSection;
use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\RXLOMNSection;
use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\TXSection;
use DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections\VOBSection;
use DentalSleepSolutions\Exceptions\RepositoryFactoryException;

class FindPatientQuerySectionFactory
{
    const QUERY_SECTIONS = [
        'allergens-check' => AllergensCheckSection::class,
        'appliance' => ApplianceSection::class,
        'appliance-since' => ApplianceSinceSection::class,
        'last-treatment' => LastTreatmentSection::class,
        'last-visit' => LastVisitSection::class,
        'ledger' => LedgerSection::class,
        'name' => NameSection::class,
        'next-visit' => NextVisitSection::class,
        'rx-lomn' => RXLOMNSection::class,
        'tx' => TXSection::class,
        'vob' => VOBSection::class,
    ];

    /**
     * @param string $column
     * @return AbstractSection|null
     * @throws RepositoryFactoryException
     */
    public function getQuerySection($column)
    {
        if (!array_key_exists($column, self::QUERY_SECTIONS)) {
            return null;
        }
        $class = self::QUERY_SECTIONS[$column];
        $object = new $class();
        if (!$object instanceof AbstractSection) {
            throw new RepositoryFactoryException("Class $class must extend " . AbstractSection::class);
        }
        return $object;
    }

    /**
     * @return AbstractSection[]
     */
    public function getAllSections()
    {
        $sections = [];
        foreach (self::QUERY_SECTIONS as $key => $column) {
            $sections[] = $this->getQuerySection($key);
        }
        return $sections;
    }
}
