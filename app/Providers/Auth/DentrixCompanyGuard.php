<?php

namespace DentalSleepSolutions\Providers\Auth;

use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalCompanyRepository;

class DentrixCompanyGuard extends AbstractGuard
{
    public function __construct(ExternalCompanyRepository $repository)
    {
        parent::__construct($repository);
    }
}
