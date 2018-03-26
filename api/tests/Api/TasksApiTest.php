<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\Task;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Eloquent\Models\Dental\User as BaseUser;
use DentalSleepSolutions\Helpers\TaskRetriever;
use Tests\TestCases\ApiTestCase;

class TasksApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Task::class;
    }

    protected function getRoute()
    {
        return '/tasks';
    }

    protected function getStoreData()
    {
        return [
            "task" => "Sed necessitatibus quisquam delectus autem.",
            "description" => "Sed soluta ut sed eos rerum et.",
            "userid" => 100,
            "responsibleid" => 4,
            "status" => 8,
            "recurring" => 8,
            "recurring_unit" => 2,
            "patientid" => 0,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'patientid'   => 100,
            'description' => 'updated task',
        ];
    }

    public function testIndex()
    {
        /** @var User $user */
        $user = User::find('u_1');
        $this->be($user);
        $this->get(self::ROUTE_PREFIX . $this->getRoute());
        $this->assertResponseOk();
        $this->assertEquals(3, count($this->getResponseData()));
        $this->assertEquals(82, $this->getResponseData()[0]['id']);
        $this->assertEquals('2014-01-10 00:00:00', $this->getResponseData()[0]['due_date']);
        $this->assertEquals(94, $this->getResponseData()[1]['id']);
        $this->assertEquals(97, $this->getResponseData()[2]['id']);
        $this->assertEquals(TaskRetriever::OVERDUE, $this->getResponseData()[0]['type']);
    }

    public function testIndexForPatient()
    {
        /** @var User $user */
        $user = User::find('u_1');
        $this->be($user);
        $patientId = 112;
        $this->get(self::ROUTE_PREFIX . '/tasks-for-patient/' . $patientId);
        $this->assertResponseOk();
        $this->assertEquals(2, count($this->getResponseData()));
        $this->assertEquals(94, $this->getResponseData()[0]['id']);
        $this->assertEquals(95, $this->getResponseData()[1]['id']);
        $this->assertEquals(TaskRetriever::OVERDUE, $this->getResponseData()[0]['type']);
    }

    public function testShow()
    {
        /** @var BaseUser $userRecord */
        $userRecord = factory(BaseUser::class)->create();
        /** @var Task $testRecord */
        $testRecord = factory($this->getModel())->create();
        $testRecord->status = Task::STATUS_INACTIVE;
        $testRecord->responsibleid = $userRecord->userid;
        $testRecord->save();

        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->$primaryKey;
        $this->get($endpoint);
        $this->assertResponseOk();
        $data = $this->getResponseData();
        $this->assertNotNull($data);
        $expectedKeys = [
            'id',
            'task',
            'description',
            'userid',
            'responsibleid',
            'status',
            'due_date',
            'recurring',
            'recurring_unit',
            'adddate',
            'ip_address',
            'patientid',
            'name',
            'firstname',
            'lastname',
        ];
        $this->assertEquals($expectedKeys, array_keys($data));
    }

    public function testDestroy()
    {
        /** @var Task $testRecord */
        $testRecord = factory($this->getModel())->create();
        $testRecord->status = Task::STATUS_INACTIVE;
        $testRecord->save();

        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->$primaryKey;

        $this->delete($endpoint);
        $this->assertResponseOk();
        $params = [
            $primaryKey => $testRecord->$primaryKey,
            'status' => Task::STATUS_DELETED,
        ];
        $this->seeInDatabase($this->model->getTable(), $params);
    }

    public function testGetType()
    {
        $type = 'all';
        $this->post(self::ROUTE_PREFIX . '/tasks/' . $type);
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }

    public function testGetTypeForPatient()
    {
        /** @var Patient $patient */
        $patient = factory(Patient::class)->create();
        $type = 'all';
        $this->post(self::ROUTE_PREFIX . '/tasks/' . $type . '/pid/' . $patient->patientid);
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }
}
