<?php

namespace DentalSleepSolutions\Providers\Auth;

use DentalSleepSolutions\Eloquent\Repositories\UserRepository;

class PatientGuard extends AbstractGuard
{
    protected $enforceCredentials = [
        'admin' => 0,
        'patient' => 1,
    ];

    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }
}
