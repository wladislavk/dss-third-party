<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Facades\ApiResponse;

class ApiPermissionResourceGroupsController extends BaseRestController
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

    public function all()
    {
        $groups = $this->repository->allWithOrder();
        $data = [];
        foreach ($groups as $group) {
            $asArray = $group->toArray();
            $asArray['resources'] = [];
            /** @var \Illuminate\Database\Eloquent\Collection $resources */
            $resources = $group->resources()->getResults();
            if ($resources) {
                $asArray['resources'] = $resources->toArray();
            }
            $data[$asArray['id']] = $asArray;
        }
        return ApiResponse::responseOk('', $data);
    }
}
