<?php

namespace DentalSleepSolutions\Eloquent\Models;

/**
 * @DSS\Manual
 *
 * Alias for User model, as EloquentUserAdapter requests a model named exactly like the repository.
 * So far, there is no alternate strategy.
 *
 * @mixin \Eloquent
 */
class UserRepository extends User
{

}
