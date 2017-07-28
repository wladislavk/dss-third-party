<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\Task;
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
