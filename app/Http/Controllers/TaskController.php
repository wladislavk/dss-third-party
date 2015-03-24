<?php namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Route;
use Request;
use Session;

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
            $dueDate = !empty($this->request['due_date']) ? date('Y-m-d', strtotime($this->request['due_date'])) : '';

            $data = array(
                'task'           => $this->request['task'],
                'due_date'       => date('Y-m-d', strtotime($dueDate)),
                'userid'         => Session::get('userid'),
                'status'         => !empty($this->request['status']) ? $this->request['status'] : 0,
                'patientid'      => $this->request['patientid'],
                'responsibleid'  => $this->request['responsibleid']
            );

            $this->task->insertData($data);
            // $message = 'Task Added!';

            return redirect('/manage/add_task')->with('closePopup', true);
        } elseif (!empty($this->request['taskedit']) && $this->request['taskedit'] == 1) {
            $dueDate = !empty($this->request['due_date']) ? date('Y-m-d', strtotime($this->request['due_date'])) : '';

            $data = array(
                'task'           => $this->request['task'],
                'due_date'       => date('Y-m-d', strtotime($dueDate)),
                'userid'         => Session::get('userid'),
                'status'         => !empty($this->request['status']) ? $this->request['status'] : 0,
                'responsibleid'  => $this->request['responsibleid']
            );

            $this->task->updateData($this->request['task_id'], $data);
            // $message = 'Task Added!';

            return redirect('/manage/add_task')->with('closePopup', true);
        }
    }
}
