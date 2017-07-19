<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\DocumentCategory;
use DentalSleepSolutions\StaticClasses\ApiResponse;

class DocumentCategoriesController extends BaseRestController
{
    public function index()
    {
        return parent::index();
    }

    public function show($id)
    {
        return parent::show($id);
    }

    public function store()
    {
        return parent::store();
    }

    public function update($id)
    {
        return parent::update($id);
    }

    public function destroy($id)
    {
        return parent::destroy($id);
    }

    /**
     * Get active document categories.
     *
     * @param DocumentCategory $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(DocumentCategory $resources)
    {
        $data = $resources->getActiveDocumentCategories();

        return ApiResponse::responseOk('', $data);
    }
}
