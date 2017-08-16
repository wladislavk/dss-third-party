<?php

namespace DentalSleepSolutions\Auth;

class UserGuard extends AbstractGuard
{
    protected $enforceCredentials = ['admin' => 0];
}
