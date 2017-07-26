<?php

namespace Tests\Dummies\Http\Controllers;

use DentalSleepSolutions\Http\Controllers\BaseRestController;

class FirstDummiesController extends BaseRestController
{
    public function getModelNamespace()
    {
        return 'Tests\\Dummies\\Eloquent';
    }

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
