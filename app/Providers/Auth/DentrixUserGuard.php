<?php

namespace DentalSleepSolutions\Providers\Auth;

use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalUserRepository;
use Illuminate\Contracts\Auth\Authenticatable;

class DentrixUserGuard extends AbstractGuard
{
    public function __construct(ExternalUserRepository $repository)
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
