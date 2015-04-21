<?php
namespace Ds3\Repositories;

use Illuminate\Support\Facades\DB;

use Ds3\Contracts\TaskInterface;
use Ds3\Eloquent\Task;

class TaskRepository implements TaskInterface
{
    public function getTasks($parameters)
    {
        $tasks = Task::join('dental_users', 'dental_task.responsibleid', '=', 'dental_users.userid')
            ->leftJoin('dental_patients', 'dental_patients.patientid', '=', 'dental_task.patientid')
            ->select(
                'dental_task.*',
                'dental_users.name',
                'dental_patients.firstname',
                'dental_patients.lastname',
                DB::raw("CONCAT(dental_users.first_name, ' ', dental_users.last_name) as full_name")
            );

        if (empty($parameters['status'])) {
            $tasks = $tasks->nonActive();
        } else {
            $tasks = $tasks->active();
        }

        if ($parameters['task'] == 'task') {
            $tasks = $tasks->where('dental_task.responsibleid', '=', $parameters['userId']);
        } else {
            $tasks = $tasks->where(function($query) use ($parameters)
            {
                $query->where('dental_users.docid', '=', $parameters['docId'])
                    ->orWhere('dental_users.userid', '=', $parameters['docId']);
            });

            if (isset($parameters['patientId'])) {
                $tasks = $tasks->where('dental_task.patientid', '=', $parameters['patientId']);
            }
        }

        if (!empty($parameters['type'])) {
            switch ($parameters['type']) {
                case 'od':
                    $tasks = $tasks->overdue();
                    break;
                case 'tod':
                    $tasks = $tasks->today();
                    break;
                case 'tom':
                    $tasks = $tasks->tomorrow();
                    break;
                case 'fut':
                    $tasks = $tasks->future();
                    break;
                case 'tw':
                    $tasks = $tasks->thisWeek($parameters['input']['thisSun']);
                    break;
                case 'nw':
                    $tasks = $tasks->nextWeek($parameters['input']['nextMon'], $parameters['input']['nextSun']);
                    break;
                case 'lat':
                    $tasks = $tasks->later($parameters['input']['nextSun'])->orderBy('dental_task.due_date', 'asc');
                    break;
                default:
                    break;
            }
        }

        if (!empty($parameters['sort'])) {
            $tasks = $tasks->orderBy($parameters['sort']['value'], $parameters['sort']['direction']);
        }

        if (!empty($parameters['limit'])) {
            $tasks = $tasks->skip($parameters['limit']['skip'])->take($parameters['limit']['take']);
        }

        return $tasks->get();
    }

    public function getJoin($id)
    {
        $task = DB::table(DB::raw('dental_task dt'))
            ->select(DB::raw('dt.*, p.firstname, p.lastname'))
            ->leftJoin(DB::raw('dental_patients p'), 'p.patientid', '=', 'dt.patientid')
            ->where('dt.id', '=', $id)
            ->first();

        return $task;
    }

    public function updateData($id, $values)
    {
        $task = Task::where('id', '=', $id)->update($values);

        return $task;
    }

    public function insertData($data)
    {
        $task = new Task();

        foreach ($data as $attribute => $value) {
            $task->$attribute = $value;
        }

        $task->save();

        return $task->id;
    }
}
