<?php

namespace DentalSleepSolutions\Helpers;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TaskRepository;
use Illuminate\Database\Eloquent\Collection;

class TaskRetriever
{
    const OVERDUE = 'overdue';
    const TODAY = 'today';
    const TOMORROW = 'tomorrow';
    const FUTURE = 'future';
    const THIS_WEEK = 'thisWeek';
    const NEXT_WEEK = 'nextWeek';
    const LATER = 'later';

    /** @var TaskRepository */
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param User $user
     * @param int $patientId
     * @return array
     */
    public function getTasksWithType(User $user, $patientId = 0)
    {
        $tasks = $this->getTasks($user, $patientId)->toArray();
        $modifiedTasks = [];
        foreach ($tasks as $task) {
            $task['type'] = $this->getTypeByDate($task['due_date'], $patientId);
            $modifiedTasks[] = $task;
        }
        return $modifiedTasks;
    }

    /**
     * @param User $user
     * @param int $patientId
     * @return Collection
     */
    private function getTasks(User $user, $patientId)
    {
        if ($patientId) {
            return $this->taskRepository->getAllForPatient($user->getDocIdOrZero(), $patientId);
        }
        return $this->taskRepository->getAll($user->getUserIdOrZero());
    }

    /**
     * @param \DateTime $taskDateTime
     * @param int $patientId
     * @return string
     */
    private function getTypeByDate(\DateTime $taskDateTime, $patientId)
    {
        $nowCarbon = Carbon::now()->startOfDay();
        $taskCarbon = Carbon::instance($taskDateTime)->startOfDay();
        $diff = $nowCarbon->diffInDays($taskCarbon, false);
        if ($diff < 0) {
            return self::OVERDUE;
        }
        if ($diff === 0) {
            return self::TODAY;
        }
        if ($diff === 1) {
            return self::TOMORROW;
        }
        if ($patientId) {
            return self::FUTURE;
        }
        $weekDiff = $nowCarbon->endOfWeek()->diffInWeeks($taskCarbon->endOfWeek(), false);
        if ($weekDiff === 0) {
            return self::THIS_WEEK;
        }
        if ($weekDiff === 1) {
            return self::NEXT_WEEK;
        }
        return self::LATER;
    }
}
