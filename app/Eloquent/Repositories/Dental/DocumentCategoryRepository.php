<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\DocumentCategory;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class DocumentCategoryRepository extends AbstractRepository
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
        return $this->model->where('status', 1)->orderBy('name')->get();
    }
}
