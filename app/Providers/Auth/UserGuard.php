<?php

namespace DentalSleepSolutions\Providers\Auth;

use DentalSleepSolutions\Eloquent\Repositories\UserRepository;

class UserGuard extends AbstractGuard
{
    protected $enforceCredentials = ['admin' => 0];

    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }
}
