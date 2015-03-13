<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Ds3\Contracts\DocumentCategoryInterface;
use Ds3\Eloquent\DocumentCategory;

class DocumentCategoryRepository implements DocumentCategoryInterface
{
    public function get()
    {
        $documentCategories = DocumentCategory::where('status', '=', 1)->orderBy('name', 'asc')->get();

        return $documentCategories;
    }
}
