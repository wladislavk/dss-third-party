<?php

namespace DentalSleepSolutions\Eloquent\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

abstract class AbstractAuthenticatableModel extends AbstractModel implements AuthenticatableContract
{
    use Authenticatable;
}
