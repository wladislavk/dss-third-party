<?php

namespace DentalSleepSolutions\Contracts\Repositories;

interface Repository
{
    public static function all($columns = ['*']);
    public static function create(array $data = []);
}
