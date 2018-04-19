<?php

namespace DentalSleepSolutions\Services\Tasks;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\Task;
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
     * @param Carbon|null $now
     * @return array
     */
    public function getTasksWithType(User $user, $patientId = 0, Carbon $now = null)
    {
        if (!$now) {
            $now = Carbon::now();
        }
        $tasks = $this->getTasks($user, $patientId);
        $modifiedTasks = [];
        foreach ($tasks as $task) {
            $date = $task->due_date;
            if (!$task->due_date instanceof \DateTime) {
                $date = new \DateTime($task->due_date);
            }
            $modifiedTask = $task->toArray();
            $modifiedTask['type'] = $this->getTypeByDate($date, $patientId, clone($now));
            $modifiedTasks[] = $modifiedTask;
        }
        return $modifiedTasks;
    }

    /**
     * @param User $user
     * @param int $patientId
     * @return Collection|Task[]
     */
    private function getTasks(User $user, $patientId)
    {
        if ($patientId) {
            return $this->taskRepository->getAllForPatient($user->getDocIdOrZero(), $patientId);
        }
        return $this->taskRepository->getAll($user->userid);
    }

    /**
     * @param \DateTime $taskDateTime
     * @param int $patientId
     * @param Carbon $now
     * @return string
     */
    private function getTypeByDate(\DateTime $taskDateTime, $patientId, Carbon $now)
    {
        $nowCarbon = $now->startOfDay();
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
