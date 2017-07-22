<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\Admin;

class AdminRepository extends AbstractRepository
{
    public function model()
    {
        return Admin::class;
    }
}
