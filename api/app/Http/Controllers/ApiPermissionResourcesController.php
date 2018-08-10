<?php

namespace DentalSleepSolutions\Http\Controllers;

class ApiPermissionResourcesController extends BaseRestController
{
    /** @var bool */
    protected $hasIp = false;

    /** @var string */
    protected $createdByAdminKey = 'created_by';

    /** @var string */
    protected $updatedByAdminKey = 'updated_by';

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
