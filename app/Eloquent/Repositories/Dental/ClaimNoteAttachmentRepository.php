<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ClaimNoteAttachment;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ClaimNoteAttachmentRepository extends AbstractRepository
{
    public function model()
    {
        return ClaimNoteAttachment::class;
    }
}
