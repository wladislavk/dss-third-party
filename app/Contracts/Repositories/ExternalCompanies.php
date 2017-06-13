<?php

namespace DentalSleepSolutions\Contracts\Repositories;

interface ExternalCompanies extends Repository
{
    public function getWithFilter($fields = [], $where = []);
}
