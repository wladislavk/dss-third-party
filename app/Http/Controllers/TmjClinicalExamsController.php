<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Http\Requests\AbstractDestroyRequest;
use DentalSleepSolutions\Http\Requests\AbstractStoreRequest;
use DentalSleepSolutions\Http\Requests\AbstractUpdateRequest;

class TmjClinicalExamsController extends BaseRestController
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
}
