<?php
namespace Ds3\Repositories;

use Ds3\Contracts\DocumentCategoryInterface;
use Ds3\Eloquent\DocumentCategory;

class DocumentCategoryRepository implements DocumentCategoryInterface
{
    public function getActiveDocumentCategories()
    {
        $documentCategories = DocumentCategory::active()->orderBy('name', 'asc')->get();

        return $documentCategories;
    }
}
