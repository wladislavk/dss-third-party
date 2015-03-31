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
    private $id;
    private $patientId;
    private $deletedId;
    private $mine;
    private $sort1;
    private $sort2;
    private $sortdir1;
    private $sortdir2;
    private $message;
    private $page1;
    private $page2;

    public function __construct(
        PatientInterface $patient,
        TaskInterface $task,
        UserInterface $user
    ) {
        $this->patient   = $patient;
        $this->task      = $task;
        $this->user      = $user;

        $this->request   = Request::all();
        $this->id        = GeneralFunctions::getRouteParameter('id');
        $this->patientId = Route::input('pid');
        $this->deletedId = GeneralFunctions::getRouteParameter('delid');
        $this->mine      = GeneralFunctions::getRouteParameter('mine');
        $this->sort1     = GeneralFunctions::getRouteParameter('sort1');
        $this->sort2     = GeneralFunctions::getRouteParameter('sort2');
        $this->sortdir1  = GeneralFunctions::getRouteParameter('sortdir1');
        $this->sortdir2  = GeneralFunctions::getRouteParameter('sortdir2');
        $this->message   = GeneralFunctions::getRouteParameter('message');
        $this->page1     = GeneralFunctions::getRouteParameter('page1');
        $this->page2     = GeneralFunctions::getRouteParameter('page2');
    }

    public function index()
    {
        $showBlock = array();

        if (!empty($this->id)) {
            $task = $this->task->getJoin($this->id);
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
            'id'             => $this->id,
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
            $dueDate = !empty($this->request['due_date']) ? Carbon::parse($this->request['due_date'])->format('Y-m-d')) : '';

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

        if ($this->mine == 1) {
            $task = 'task';
        } else {
            $task = '';
        }

        if (!empty($this->sort1)) {
            switch ($this->sort1) {
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
            $this->request['sort1'] = 'name';
            $this->request['sortdir1'] = 'DESC';
            $sort = 'due_date';
        }

        if (!empty($this->request['sortdir1'])) {
            $dir = $this->request['sortdir1'];
        } else {
            $dir = 'DESC';
        }

        $quantityDisplayedRecords = 10;

        if (!empty($this->page1)) {
            $indexValTop = $this->page1;
        } else {
            $indexValTop = 0;
        }

        $iVal = $indexValTop * $quantityDisplayedRecords;
        $totalRecords = $this->task->getTasks(
            Session::get('userId'),
            Session::get('docId'),
            null,
            $task,
            null,
            null,
            array('value' => $sort, 'direction' => $dir)
        );

        $noPagesTop = count($totalRecords) / $quantityDisplayedRecords;
        $topTasks = $this->task->getTasks(
            Session::get('userId'),
            Session::get('docId'),
            null,
            $task,
            null,
            null,
            array('value' => $sort, 'direction' => $dir),
            array('skip' => $iVal, 'take' => $quantityDisplayedRecords)
        );

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

        if (!empty($this->sort2)) {
            switch ($this->sort2) {
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
            $this->request['sort2'] = 'name';
            $this->request['sortdir2'] = 'DESC';
            $sort = 'due_date';
        }

        if (!empty($this->request['sortdir2'])) {
            $dir = $this->request['sortdir2'];
        } else {
            $dir = 'DESC';
        }

        if (!empty($this->page2)) {
            $indexValBottom = $this->page2;
        } else {
            $indexValBottom = 0;
        }

        $iVal = $indexValBottom * $quantityDisplayedRecords;
        $totalRecords = $this->task->getTasks(
            Session::get('userId'),
            Session::get('docId'),
            null,
            $task,
            null,
            null,
            array('value' => $sort, 'direction' => $dir),
            null,
            1
        );

        $noPagesBottom = count($totalRecords) / $quantityDisplayedRecords;
        $bottomTasks = $this->task->getTasks(
            Session::get('userId'),
            Session::get('docId'),
            null,
            $task,
            null,
            null,
            array('value' => $sort, 'direction' => $dir),
            array('skip' => $iVal, 'take' => $quantityDisplayedRecords),
            1
        );

        // send data to view

        foreach ($this->request as $name => $value) {
            $data[$name] = $value;
        }

        $data = array_merge($data, array(
            'mine'           => $this->mine,
            'noPagesTop'     => $noPagesTop,
            'noPagesBottom'  => $noPagesBottom,
            'indexValTop'    => $indexValTop,
            'indexValBottom' => $indexValBottom,
            'sort1'          => $this->sort1,
            'sort2'          => $this->sort2,
            'sortdir1'       => strtolower($this->sortdir1),
            'sortdir2'       => strtolower($this->sortdir2),
            'page1'          => $this->page1,
            'page2'          => $this->page2,
            'topTasks'       => $topTasks,
            'bottomTasks'    => $bottomTasks
        ));

        // dd($data);

        return view('manage.tasks', $data);
    }
}
