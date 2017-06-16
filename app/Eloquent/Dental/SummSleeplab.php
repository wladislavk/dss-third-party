<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;

class SummSleeplab extends AbstractModel
{
    protected $table = 'dental_summ_sleeplab';

    /**
     * @param int $patientId
     * @return SummSleeplab|null
     */
    public function getPatientDiagnosis($patientId)
    {
        /** @var SummSleeplab|null $diagnosis */
        $diagnosis = $this->select('diagnosis')
            ->where(function($query) {
                $query->whereNotNull('diagnosis')
                    ->where('diagnosis', '!=', '');
            })->whereNotNull('filename')
            ->where('patiendid', $patientId)
            ->orderBy('id', 'desc')
            ->first();
        return $diagnosis;
    }
}
