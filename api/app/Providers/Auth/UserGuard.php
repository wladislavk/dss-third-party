<?php

namespace DentalSleepSolutions\Providers\Auth;

use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;

class UserGuard extends AbstractGuard
{
    /** @var array */
    protected $enforceCredentials = ['admin' => 0];

    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }
}
