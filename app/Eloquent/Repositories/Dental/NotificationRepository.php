<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Notification;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class NotificationRepository extends AbstractRepository
{
    public function model()
    {
        return Notification::class;
    }
}
