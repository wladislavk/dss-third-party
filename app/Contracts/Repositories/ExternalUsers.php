<?php

namespace DentalSleepSolutions\Contracts\Repositories;

interface ExternalUsers extends Repository
{
    public function getWithFilter($fields = [], $where = []);
}
