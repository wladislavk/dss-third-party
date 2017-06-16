<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\DocumentCategories;

class DocumentCategoriesController extends Controller
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
     * @param  \DentalSleepSolutions\Contracts\Repositories\DocumentCategories $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(DocumentCategories $resources)
    {
        $data = $resources->getActiveDocumentCategories();

        return ApiResponse::responseOk('', $data);
    }
}
