<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\Tasks;

class TasksController extends BaseRestController
{
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
        return parent::index();
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
     */
    public function show($id)
    {
        return parent::show($id);
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
     */
    public function destroy($id)
    {
        return parent::destroy($id);
    }

    public function getType($type, Tasks $resources)
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

    public function getTypeForPatient($type, $patientId, Tasks $resources)
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
