<?php

namespace DentalSleepSolutions\Providers\Auth;

use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalCompanyRepository;
use Illuminate\Contracts\Auth\Authenticatable;

class DentrixCompanyGuard extends AbstractGuard
{
    public function __construct(ExternalCompanyRepository $repository)
    {
        parent::__construct($repository);
    }

    public function setUser(Authenticatable $user)
    {
        return $this->user();
    }

    public function id()
    {
        return $this->user()->getAuthIdentifier();
    }
}
