<?php

namespace DentalSleepSolutions\Contracts\Resources;

interface HealthHistory extends Resource
{
    public function getWithFilter($fields = [], $where = []);
}
