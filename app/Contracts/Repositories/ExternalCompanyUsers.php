<?php

namespace DentalSleepSolutions\Contracts\Repositories;

interface ExternalCompanyUsers extends Repository
{
    public function getWithFilter($fields = [], $where = []);
}
