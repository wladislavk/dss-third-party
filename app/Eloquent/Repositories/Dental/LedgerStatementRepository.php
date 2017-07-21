<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerStatement;
use Prettus\Repository\Eloquent\BaseRepository;

class LedgerStatementRepository extends BaseRepository
{
    public function model()
    {
        return LedgerStatement::class;
    }

    /**
     * @param int $id
     * @param int $patientId
     * @return bool|null
     */
    public function removeByIdAndPatientId($id, $patientId)
    {
        return $this->model->where('id', $id)
            ->where('patientid', $patientId)
            ->delete();
    }
}
