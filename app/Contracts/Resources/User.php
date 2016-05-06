<?php

namespace DentalSleepSolutions\Contracts\Resources;

interface User extends Resource
{
    public function getUserType($userId);
}
