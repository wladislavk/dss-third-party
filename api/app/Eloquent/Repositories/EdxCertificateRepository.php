<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\EdxCertificate;

class EdxCertificateRepository extends AbstractRepository
{
    public function model()
    {
        return EdxCertificate::class;
    }
}
