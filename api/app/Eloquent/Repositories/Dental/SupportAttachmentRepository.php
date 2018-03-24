<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SupportAttachment;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class SupportAttachmentRepository extends AbstractRepository
{
    public function model()
    {
        return SupportAttachment::class;
    }
}
