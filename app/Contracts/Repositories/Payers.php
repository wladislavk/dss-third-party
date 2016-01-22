<?php

namespace DentalSleepSolutions\Contracts\Repositories;

interface Payers extends Repository
{
    public function findByUid($uid);
}
