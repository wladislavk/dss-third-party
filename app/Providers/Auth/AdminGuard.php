<?php

namespace DentalSleepSolutions\Providers\Auth;

use DentalSleepSolutions\Eloquent\Repositories\UserRepository;

class AdminGuard extends AbstractGuard
{
    protected $enforceCredentials = ['admin' => 1];

    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }
}
