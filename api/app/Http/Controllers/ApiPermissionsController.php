<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Facades\ApiResponse;
use Illuminate\Database\Eloquent\Builder;

class ApiPermissionsController extends BaseRestController
{
    /** @var bool */
    var $hasIp = false;

    /** @var string */
    var $ipAddressKey = '';

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
        $models = $this->findAllModels();
        $data = [];
        foreach ($models as $model) {
            $data[$model->group_id] = $model->toArray();
        }
        return ApiResponse::responseOk('', $data);
    }

    public function bulkUpdate()
    {
        $groups = $this->request->input('permissions');
        $docId = $this->user()->normalizedDocId();
        $patientId = $this->patient()->patientid;
        $this->updateGroups($groups, $docId, $patientId);
        $data = $this->findAllModels();
        return ApiResponse::responseOk('', $data);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function findAllModels()
    {
        return $this->repository
            ->getWithFilter([], [
                'doc_id' => $this->user()->normalizedDocId(),
                'patient_id' => $this->patient()->patientid,
            ])
            ->all()
        ;
    }

    /**
     * @param array $groups
     * @param int   $docId
     * @param int   $patientId
     */
    protected function updateGroups(array $groups, $docId, $patientId)
    {
        $docId = (int)$docId;
        $patientId = (int)$patientId;
        $deleteIds = [];
        $updateIds = [];
        foreach ($groups as $group) {
            if ($group['enabled']) {
                $updateIds[] = $group['group_id'];
                continue;
            }
            $deleteIds[] = $group['group_id'];
        }
        if (sizeof($deleteIds)) {
            $this->repository->deleteWithFilter(function (Builder $query) use ($docId, $patientId, $deleteIds) {
                $query->where('doc_id', $docId)
                    ->where('patient_id', $patientId)
                    ->whereIn('group_id', $deleteIds)
                ;
            });
        }
        if (!sizeof($updateIds)) {
            return;
        }
        $updateModels = [];
        foreach ($updateIds as $groupId) {
            $updateModels[] = [
                'group_id' => $groupId,
                'doc_id' => $docId,
                'patient_id' => $patientId,
            ];
        }
        $this->repository->bulkInsert($updateModels);
    }

    /**
     * @param int $id
     * @return Resource
     */
    protected function findSingleModel($id)
    {
        /** @var Resource $resource */
        $resource = $this->repository->findOrFail($id);
        return $resource;
    }
}
