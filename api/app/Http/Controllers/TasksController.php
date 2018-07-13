<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TaskRepository;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Services\Tasks\TaskRetriever;
use Illuminate\Http\JsonResponse;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Auth\Factory as Auth;

class TasksController extends BaseRestController
{
    /** @var TaskRepository */
    protected $repository;

    /** @var TaskRetriever */
    private $taskRetriever;

    public function __construct(
        Auth $auth,
        Config $config,
        AbstractRepository $repository,
        Request $request,
        TaskRetriever $taskRetriever
    ) {
        parent::__construct($auth, $config, $repository, $request);
        $this->taskRetriever = $taskRetriever;
    }

    /**
     * @SWG\Get(
     *     path="/tasks",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/Task")
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function index()
    {
        $tasks = $this->taskRetriever->getTasksWithType($this->user());
        return ApiResponse::responseOk('', $tasks);
    }

    /**
     * @SWG\Manual
     * @todo: this method should be moved to GET /patients/{id}/tasks
     *
     * @SWG\Get(
     *     path="/tasks-for-patient/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/Task")
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function indexForPatient($id)
    {
        $tasks = $this->taskRetriever->getTasksWithType($this->user(), $id);
        return ApiResponse::responseOk('', $tasks);
    }

    /**
     * @SWG\Get(
     *     path="/tasks/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Task")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $task = $this->repository->getSpecificTask($id);
        return ApiResponse::responseOk('', $task);
    }

    /**
     * @SWG\Post(
     *     path="/tasks",
     *     @SWG\Parameter(name="task", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="description", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="responsibleid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="due_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="recurring", in="formData", type="integer"),
     *     @SWG\Parameter(name="recurring_unit", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Task")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function store()
    {
        return parent::store();
    }

    /**
     * @SWG\Put(
     *     path="/tasks/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="task", in="formData", type="string"),
     *     @SWG\Parameter(name="description", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="responsibleid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="due_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="recurring", in="formData", type="integer"),
     *     @SWG\Parameter(name="recurring_unit", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function update($id)
    {
        return parent::update($id);
    }

    /**
     * @SWG\Delete(
     *     path="/tasks/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="Resource deleted", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $this->repository->deleteTask($id);
        return ApiResponse::responseOk('Resource deleted');
    }

    // @todo: these methods are possibly obsolete

    /**
     * @SWG\Post(
     *     path="/tasks/{type}",
     *     @SWG\Parameter(name="type", in="path", type="string", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function getType($type)
    {
        switch ($type) {
            case 'all':
                $tasks = $this->repository->getAll($this->user()->userid);
                break;
            case 'overdue':
                $tasks = $this->repository->getOverdue($this->user()->userid);
                break;
            case 'today':
                $tasks = $this->repository->getToday($this->user()->userid);
                break;
            case 'tomorrow':
                $tasks = $this->repository->getTomorrow($this->user()->userid);
                break;
            case 'this-week':
                $tasks = $this->repository->getThisWeek($this->user()->userid);
                break;
            case 'next-week':
                $tasks = $this->repository->getNextWeek($this->user()->userid);
                break;
            case 'later':
                $tasks = $this->repository->getLater($this->user()->userid);
                break;
            default:
                $tasks = [];
        }

        return ApiResponse::responseOk('', $tasks);
    }

    /**
     * @SWG\Post(
     *     path="/tasks/{type}/pid/{patientId}",
     *     @SWG\Parameter(name="type", in="path", type="string", required=true),
     *     @SWG\Parameter(name="patientId", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param string $type
     * @param int $patientId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTypeForPatient($type, $patientId)
    {
        switch ($type) {
            case 'all':
                $tasks = $this->repository->getAllForPatient($this->user()->docid, $patientId);
                break;
            case 'overdue':
                $tasks = $this->repository->getOverdueForPatient($this->user()->docid, $patientId);
                break;
            case 'today':
                $tasks = $this->repository->getTodayForPatient($this->user()->docid, $patientId);
                break;
            case 'tomorrow':
                $tasks = $this->repository->getTomorrowForPatient($this->user()->docid, $patientId);
                break;
            case 'future':
                $tasks = $this->repository->getFutureForPatient($this->user()->docid, $patientId);
                break;
            default:
                $tasks = [];
        }

        return ApiResponse::responseOk('', $tasks);
    }
}
