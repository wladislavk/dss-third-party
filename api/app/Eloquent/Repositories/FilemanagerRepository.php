<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\Filemanager;

class FilemanagerRepository extends AbstractRepository
{
    public function model()
    {
        return Filemanager::class;
    }
}
