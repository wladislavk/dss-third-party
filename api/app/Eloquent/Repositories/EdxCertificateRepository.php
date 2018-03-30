<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\EdxCertificate;
use Illuminate\Support\Collection;

class EdxCertificateRepository extends AbstractRepository
{
    public function model()
    {
        return EdxCertificate::class;
    }


    /**
     * @param int $userId
     * @return EdxCertificate[]|Collection
     */
    public function getByUserId(int $userId): iterable
    {
        $result = $this->model
            ->select(\DB::raw('c.*'))
            ->from(\DB::raw('edx_certificates c'))
            ->join(\DB::raw('dental_users u'), 'c.edx_id', '=', 'u.edx_id')
            ->where('u.userid', $userId)
        ;
        return $result->get();
    }
}
