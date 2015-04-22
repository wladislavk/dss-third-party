<?php
namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Route;
use Request;
use Session;
use Carbon\Carbon;

use Ds3\Libraries\GeneralFunctions;
use Ds3\Contracts\PatientInterface;
use Ds3\Contracts\TaskInterface;
use Ds3\Contracts\UserInterface;

class TaskController extends Controller
{
    private $patient;
    private $task;
    private $user;

    private $request;
    private $taskId;
    private $patientId;
    private $deletedId;
    private $mineTask;
    private $sortTopTasks;
    private $sortBottomTasks;
    private $sortDirectionTopTasks;
    private $sortDirectionBottomTasks;
    private $message;
    private $topPageNumber;
    private $bottomPageNumber;

    public function __construct(
        PatientInterface $patient,
        TaskInterface $task,
        UserInterface $user
    ) {
        $this->patient                  = $patient;
        $this->task                     = $task;
        $this->user                     = $user;

        $this->request                  = Request::all();
        $this->taskId                   = GeneralFunctions::getRouteParameter('id');
        $this->patientId                = Route::input('pid');
        $this->deletedId                = GeneralFunctions::getRouteParameter('delid');
        $this->mineTask                 = GeneralFunctions::getRouteParameter('mine');
        $this->sortTopTasks             = GeneralFunctions::getRouteParameter('sort1');
        $this->sortBottomTasks          = GeneralFunctions::getRouteParameter('sort2');
        $this->sortDirectionTopTasks    = GeneralFunctions::getRouteParameter('sortdir1');
        $this->sortDirectionBottomTasks = GeneralFunctions::getRouteParameter('sortdir2');
        $this->message                  = GeneralFunctions::getRouteParameter('message');
        $this->topPageNumber            = GeneralFunctions::getRouteParameter('page1');
        $this->bottomPageNumber         = GeneralFunctions::getRouteParameter('page2');
    }

    public function index()
    {
        $showBlock = array();

        if (!empty($this->taskId)) {
            $task = $this->task->getJoin($this->taskId);
        } else {
            $task = null;
        }

        if ($this->patientId) {
            $patients = $this->patient->getPatients(array(
                'patientid' => $this->patientId
            ));
        } else {
            if (!empty($task->firstname) && !empty($task->lastname)) {
                $showBlock['newTask'] = '(' . $task->firstname . ' ' . $task->lastname . ')';
            }
        }

        $responsibleId = !empty($task->responsibleid) ? $task->responsibleid : Session::get('userid');
        $users = $this->user->getResponsible(Session::get('docId'), Session::get('docId'));

        $data = array(
            'showBlock'      => $showBlock,
            'id'             => $this->taskId,
            'patientId'      => $this->patientId,
            'task'           => $task,
            'patient'        => !empty($patients) ? $patients[0] : null,
            'users'          => $users,
            'responsibleId'  => $responsibleId,
            'closePopup'     => !empty(Session::get('closePopup')) ? Session::get('closePopup') : null
        );

        return view('manage.add_task', $data);
    }

    public function add()
    {
        if (!empty($this->request['taskadd']) && $this->request['taskadd'] == 1) {
            $dueDate = !empty($this->request['due_date']) ? Carbon::parse($this->request['due_date'])->format('Y-m-d') : '';

            $data = array(
                'task'           => $this->request['task'],
                'due_date'       => Carbon::parse($dueDate)->format('Y-m-d'),
                'userid'         => Session::get('userid'),
                'status'         => !empty($this->request['status']) ? $this->request['status'] : 0,
                'patientid'      => $this->request['patientid'],
                'responsibleid'  => $this->request['responsibleid']
            );

            $this->task->insertData($data);
            // $message = 'Task Added!';
        } elseif (!empty($this->request['taskedit']) && $this->request['taskedit'] == 1) {
            $dueDate = !empty($this->request['due_date']) ? Carbon::parse($this->request['due_date'])->format('Y-m-d') : '';

            $data = array(
                'task'           => $this->request['task'],
                'due_date'       => Carbon::parse($dueDate)->format('Y-m-d'),
                'userid'         => Session::get('userid'),
                'status'         => !empty($this->request['status']) ? $this->request['status'] : 0,
                'responsibleid'  => $this->request['responsibleid']
            );

            $this->task->updateData($this->request['task_id'], $data);
            // $message = 'Task Added!';
        }

        return redirect('/manage/add_task')->with('closePopup', true);
    }

    public function manageTasks()
    {
        if (!empty($this->deletedId)) {
            $this->task->updateData($this->deletedId, array(
                'status' => 2
            ));

            return redirect('/manage/tasks');
        }

        if ($this->mineTask == 1) {
            $task = 'task';
        } else {
            $task = '';
        }

        if (!empty($this->sortTopTasks)) {
            switch ($this->sortTopTasks) {
                case 'due_date':
                    $sort = 'due_date';
                    break;
                case 'task':
                    $sort = 'task';
                    break;
                case 'responsible':
                    $sort = 'du.name';
                    break;
                default:
                    break;
            }
        } else {
            $this->sortTopTasks = 'name';
            $this->sortDirectionTopTasks = 'DESC';
            $sort = 'due_date';
        }

        if (!empty($this->sortDirectionTopTasks)) {
            $dir = $this->sortDirectionTopTasks;
        } else {
            $dir = 'DESC';
        }

        $quantityDisplayedRecords = 10;

        if (!empty($this->topPageNumber)) {
            $indexValTop = $this->topPageNumber;
        } else {
            $indexValTop = 0;
        }

        $iVal = $indexValTop * $quantityDisplayedRecords;

        $parameters = array(
            'userId'    => Session::get('userId'),
            'docId'     => Session::get('docId'),
            'patientId' => null,
            'task'      => $task,
            'sort'      => array('value' => $sort, 'direction' => $dir)
        );

        $totalRecords = $this->task->getTasks($parameters);

        $noPagesTop = count($totalRecords) / $quantityDisplayedRecords;
        $parameters['limit'] = array('skip' => $iVal, 'take' => $quantityDisplayedRecords);
        $topTasks = $this->task->getTasks($parameters);

        $today = strtotime(Carbon::now());
        $tomorrow = strtotime(Carbon::tomorrow());

        if (count($topTasks)) foreach ($topTasks as $task) {
            $due = strtotime(Carbon::parse($task->due_date));

            if ($due < $today) {
                $type = 'expired';
            } elseif ($due == $today) {
                $type = 'today';
            } elseif ($due == $tomorrow) {
                $type = 'tomorrow';
            } else {
                $type = Carbon::parse($task->due_date)->format('m/d/Y');
            }

            $task->type = $type;
        }

        if (!empty($this->sortBottomTasks)) {
            switch ($this->sortBottomTasks) {
                case 'due_date':
                    $sort = 'due_date';
                    break;
                case 'task':
                    $sort = 'task';
                    break;
                case 'responsible':
                    $sort = 'du.name';
                    break;
                default:
                    break;
            }
        } else {
            $this->sortBottomTasks = 'name';
            $this->sortDirectionBottomTasks = 'DESC';
            $sort = 'due_date';
        }

        if (!empty($this->sortDirectionBottomTasks)) {
            $dir = $this->sortDirectionBottomTasks;
        } else {
            $dir = 'DESC';
        }

        if (!empty($this->bottomPageNumber)) {
            $indexValBottom = $this->bottomPageNumber;
        } else {
            $indexValBottom = 0;
        }

        $iVal = $indexValBottom * $quantityDisplayedRecords;

        $parameters = array(
            'userId'    => Session::get('userId'),
            'docId'     => Session::get('docId'),
            'patientId' => null,
            'task'      => $task,
            'sort'      => array('value' => $sort, 'direction' => $dir),
            'status'    => 1
        );

        $totalRecords = $this->task->getTasks($parameters);

        $noPagesBottom = count($totalRecords) / $quantityDisplayedRecords;
        $parameters['limit'] = array('skip' => $iVal, 'take' => $quantityDisplayedRecords);
        $bottomTasks = $this->task->getTasks($parameters);

        // send data to view

        foreach ($this->request as $name => $value) {
            $data[$name] = $value;
        }

        $data = array_merge($data, array(
            'mine'           => $this->mineTask,
            'noPagesTop'     => $noPagesTop,
            'noPagesBottom'  => $noPagesBottom,
            'indexValTop'    => $indexValTop,
            'indexValBottom' => $indexValBottom,
            'sort1'          => $this->sortTopTasks,
            'sort2'          => $this->sortBottomTasks,
            'sortdir1'       => strtolower($this->sortDirectionTopTasks),
            'sortdir2'       => strtolower($this->sortDirectionBottomTasks),
            'page1'          => $this->topPageNumber,
            'page2'          => $this->bottomPageNumber,
            'topTasks'       => $topTasks,
            'bottomTasks'    => $bottomTasks
        ));

        // dd($data);

        return view('manage.tasks', $data);
    }
}
