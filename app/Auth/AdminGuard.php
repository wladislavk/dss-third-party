<?php

namespace DentalSleepSolutions\Auth;

class AdminGuard extends AbstractGuard
{
    protected $enforceCredentials = ['admin' => 1];
}
