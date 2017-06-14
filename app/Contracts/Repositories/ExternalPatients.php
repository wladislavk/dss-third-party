<?php

namespace DentalSleepSolutions\Contracts\Repositories;

interface ExternalPatients extends Repository
{
    public function getWithFilter($fields = [], $where = []);
}
