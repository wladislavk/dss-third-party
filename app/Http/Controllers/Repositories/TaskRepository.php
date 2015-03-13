<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\TaskInterface;
use Ds3\Eloquent\Task;

class TaskRepository implements TaskInterface
{
    public function get($userId, $docId, $patientId, $task, $type = null, $input = null)
    {
        $tasks = Task::join('dental_users', 'dental_task.responsibleid', '=', 'dental_users.userid')
            ->leftJoin('dental_patients', 'dental_patients.patientid', '=', 'dental_task.patientid')
            ->select('dental_task.*', 'dental_users.name', 'dental_patients.firstname', 'dental_patients.lastname')
            ->where(function($query)
            {
                $query->where('dental_task.status', '=', '0')
                      ->orWhereNull('dental_task.status');
            });

        if ($task == 'task') {
            $tasks = $tasks->where('dental_task.responsibleid', '=', $userId);
        } else {
            $tasks = $tasks->whereRaw('(dental_users.docid = ' . $docId . ' OR dental_users.userid = ' . $docId . ')')
                ->where('dental_task.patientid', '=', $patientId);
        }

        switch ($type) {
            case 'od':
                $tasks = $tasks->where('dental_task.due_date', '<', 'CURDATE()');
                break;
            case 'tod':
                $tasks = $tasks->where('dental_task.due_date', '=', 'CURDATE()');
                break;
            case 'tom':
                $tasks = $tasks->where('dental_task.due_date', '=', 'DATE_ADD(CURDATE(), INTERVAL 1 DAY)');
                break;
            case 'fut':
                $tasks = $tasks->where('dental_task.due_date', '>', 'DATE_ADD(CURDATE(), INTERVAL 1 DAY)');
                break;
            case 'tw':
                $tasks = $tasks->whereRaw("dental_task.due_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 2 DAY) AND '" . $input['thisSun'] . "'");
                break;
            case 'nw':
                $tasks = $tasks->whereBetween('dental_task.due_date', array($input['nextMon'], $input['nextSun']));
                break;
            case 'lat':
                $tasks = $tasks->where('dental_task.due_date', '>', $input['nextSun'])
                    ->orderBy('dental_task.due_date', 'asc');
                break;
            default:
                break;
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

        try {
            $task->save();
        } catch (ModelNotFoundException $e) {
            return null;
        }

        return $task->id;
    }
}
