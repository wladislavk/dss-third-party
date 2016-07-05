<?php

namespace DentalSleepSolutions\Contracts\Repositories;

interface Patients extends Repository
{
    public function getWithFilter($fields = [], $where = []);
}
