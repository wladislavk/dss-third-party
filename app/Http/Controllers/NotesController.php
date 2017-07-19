<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\Note;
use DentalSleepSolutions\StaticClasses\ApiResponse;

class NotesController extends BaseRestController
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

    public function getUnsigned(Note $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getUnsigned($docId);

        return ApiResponse::responseOk('', $data);
    }
}
