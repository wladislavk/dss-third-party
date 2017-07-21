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

    /**
     * @return DocumentCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getActiveDocumentCategories()
    {
        return DocumentCategory::active()->orderBy('name')->get();
    }
}
