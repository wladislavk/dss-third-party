<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections;

abstract class AbstractAdvanceOrderingSection extends AbstractSection
{
    public function getOrderSQL($dir)
    {
        $orderColumns = [
            'patient_info DESC',
            $this->getInnerOrderSQL($dir),
            'p.lastname ASC',
            'p.firstname ASC',
        ];
        return join(', ', array_filter($orderColumns));
    }

    /**
     * @param string $dir
     * @return string
     */
    abstract protected function getInnerOrderSQL($dir);
}
