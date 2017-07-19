<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\Task;
use DentalSleepSolutions\StaticClasses\ApiResponse;

class TasksController extends BaseRestController
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

    public function getType($type, Task $resources)
    {
        $userId = $this->currentUser->id ?: 0;

        switch ($type) {
            case 'all':
                $tasks = $resources->getAll($userId);
                break;
            case 'overdue':
                $tasks = $resources->getOverdue($userId);
                break;
            case 'today':
                $tasks = $resources->getToday($userId);
                break;
            case 'tomorrow':
                $tasks = $resources->getTomorrow($userId);
                break;
            case 'this-week':
                $tasks = $resources->getThisWeek($userId);
                break;
            case 'next-week':
                $tasks = $resources->getNextWeek($userId);
                break;
            case 'later':
                $tasks = $resources->getLater($userId);
                break;
            default:
                $tasks = [];
                break;
        }

        return ApiResponse::responseOk('', $tasks);
    }

    public function getTypeForPatient($type, $patientId, Task $resources)
    {
        $docId     = $this->currentUser->docid ?: 0;
        $patientId = $patientId ?: 0;

        switch ($type) {
            case 'all':
                $tasks = $resources->getAllForPatient($docId, $patientId);
                break;
            case 'overdue':
                $tasks = $resources->getOverdueForPatient($docId, $patientId);
                break;
            case 'today':
                $tasks = $resources->getTodayForPatient($docId, $patientId);
                break;
            case 'tomorrow':
                $tasks = $resources->getTomorrowForPatient($docId, $patientId);
                break;
            case 'future':
                $tasks = $resources->getFutureForPatient($docId, $patientId);
                break;
            default:
                $tasks = [];
                break;
        }

        return ApiResponse::responseOk('', $tasks);
    }
}
