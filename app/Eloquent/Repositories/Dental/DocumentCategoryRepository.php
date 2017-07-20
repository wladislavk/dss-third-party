<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\DocumentCategory;
use Prettus\Repository\Eloquent\BaseRepository;

class DocumentCategoryRepository extends BaseRepository
{
    public function model()
    {
        return DocumentCategory::class;
    }
}
