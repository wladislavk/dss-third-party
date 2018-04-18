<?php

namespace Tests\Unit\Services;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\Task;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TaskRepository;
use DentalSleepSolutions\Services\TaskRetriever;
use Illuminate\Database\Eloquent\Collection;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class TaskRetrieverTest extends UnitTestCase
{
    /** @var User */
    private $user;

    /** @var Carbon */
    private $currentDate;

    /** @var Collection|Task[] */
    private $tasks;

    /** @var TaskRetriever */
    private $taskRetriever;

    public function setUp()
    {
        $this->user = new User();

        // strip timezone
        $this->currentDate = new Carbon('@' . (new Carbon())->startOfWeek()->addDay(1)->timestamp);
        $now = new \DateTimeImmutable('@' . $this->currentDate->timestamp);

        $taskOverdue = new Task();
        $taskOverdue->id = 1;
        $taskOverdue->patientid = 5;
        $taskOverdue->due_date = $this->immutableToDateTime($now->sub(new \DateInterval('P1D')));
        $taskOverdueForOtherPatient = new Task();
        $taskOverdueForOtherPatient->id = 2;
        $taskOverdueForOtherPatient->patientid = 6;
        $taskOverdueForOtherPatient->due_date = $this->immutableToDateTime($now->sub(new \DateInterval('P2D')));
        $taskToday = new Task();
        $taskToday->id = 3;
        $taskToday->patientid = 5;
        $taskToday->due_date = $this->immutableToDateTime($now);
        $taskTomorrow = new Task();
        $taskTomorrow->id = 4;
        $taskTomorrow->patientid = 5;
        $taskTomorrow->due_date = $this->immutableToDateTime($now->add(new \DateInterval('P1D')));
        $taskThisWeek = new Task();
        $taskThisWeek->id = 5;
        $taskThisWeek->patientid = 5;
        $taskThisWeek->due_date = $this->immutableToDateTime($now->add(new \DateInterval('P3D')));
        $taskNextWeek = new Task();
        $taskNextWeek->id = 6;
        $taskNextWeek->patientid = 5;
        $taskNextWeek->due_date = $this->immutableToDateTime($now->add(new \DateInterval('P10D')));
        $taskLater = new Task();
        $taskLater->id = 7;
        $taskLater->patientid = 5;
        $taskLater->due_date = $this->immutableToDateTime($now->add(new \DateInterval('P20D')));
        $this->tasks = new Collection();
        $this->tasks
            ->add($taskOverdue)
            ->add($taskOverdueForOtherPatient)
            ->add($taskToday)
            ->add($taskTomorrow)
            ->add($taskThisWeek)
            ->add($taskNextWeek)
            ->add($taskLater)
        ;

        $taskRepository = $this->mockTaskRepository();
        $this->taskRetriever = new TaskRetriever($taskRepository);
    }

    public function testRetrieveTasks()
    {
        $tasks = $this->taskRetriever->getTasksWithType($this->user, null, $this->currentDate);
        $this->assertEquals(7, sizeof($tasks));
        $this->assertEquals(TaskRetriever::OVERDUE, $tasks[0]['type']);
        $this->assertEquals(TaskRetriever::OVERDUE, $tasks[1]['type']);
        $this->assertEquals(TaskRetriever::TODAY, $tasks[2]['type']);
        $this->assertEquals(TaskRetriever::TOMORROW, $tasks[3]['type']);
        $this->assertEquals(TaskRetriever::THIS_WEEK, $tasks[4]['type']);
        $this->assertEquals(TaskRetriever::NEXT_WEEK, $tasks[5]['type']);
        $this->assertEquals(TaskRetriever::LATER, $tasks[6]['type']);
    }

    public function testRetrieveTasksForPatient()
    {
        $patientId = 5;
        $tasks = $this->taskRetriever->getTasksWithType($this->user, $patientId, $this->currentDate);
        $this->assertEquals(6, sizeof($tasks));
        $this->assertEquals(TaskRetriever::OVERDUE, $tasks[0]['type']);
        $this->assertEquals(TaskRetriever::TODAY, $tasks[1]['type']);
        $this->assertEquals(TaskRetriever::TOMORROW, $tasks[2]['type']);
        $this->assertEquals(TaskRetriever::FUTURE, $tasks[3]['type']);
        $this->assertEquals(TaskRetriever::FUTURE, $tasks[4]['type']);
        $this->assertEquals(TaskRetriever::FUTURE, $tasks[5]['type']);
    }

    private function mockTaskRepository()
    {
        /** @var TaskRepository|MockInterface $taskRepository */
        $taskRepository = \Mockery::mock(TaskRepository::class);
        $taskRepository->shouldReceive('getAll')->andReturn($this->tasks);
        $taskRepository->shouldReceive('getAllForPatient')
            ->andReturnUsing(function ($docId, $patientId) {
                $patientTasks = [];
                foreach ($this->tasks as $task) {
                    if ($task->patientid == $patientId) {
                        $patientTasks[] = $task;
                    }
                }
                return $patientTasks;
            });
        return $taskRepository;
    }

    /**
     * @param \DateTimeImmutable $dateTimeImmutable
     * @return \DateTime
     */
    private function immutableToDateTime(\DateTimeImmutable $dateTimeImmutable)
    {
        return new \DateTime('@' . $dateTimeImmutable->getTimestamp());
    }
}
