<?php

namespace DentalSleepSolutions\Contracts\Resources;

interface User extends Resource
{
    public function check($username, $password);
    public function getSalt($username);
    public function getUserType($userId);
    public function getCourseStaff($userId);
}
