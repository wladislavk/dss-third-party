<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\EvaluationManagementExam;
use Tests\TestCases\ApiTestCase;

class EvaluationManagementExamsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return EvaluationManagementExam::class;
    }

    protected function getRoute()
    {
        return '/evaluation-management-exams';
    }

    protected function getStoreData()
    {
        $model = factory($this->getModel())->make();
        $data = $model->toArray();
        $data = [
            'history' => $data['history'],
            'systems' => $data['systems'],
            'vital_signs' => $data['vital_signs'],
            'body_area' => $data['body_area'],
        ];
        return $data;
    }

    protected function getUpdateData()
    {
        $model = factory($this->getModel())->make();
        $data = $model->toArray();
        $data = [
            'history' => $data['history'],
            'systems' => $data['systems'],
            'vital_signs' => $data['vital_signs'],
            'body_area' => $data['body_area'],
        ];
        return $data;
    }

    public function testStore()
    {
        $storeData = $this->getStoreData();
        $this->post(self::ROUTE_PREFIX . $this->getRoute(), $storeData);
        $this->assertResponseOk();
        $this->seeJsonInDatabase($this->model->getTable(), $storeData);
    }

    public function testUpdate()
    {
        $testRecord = factory($this->getModel())->create();
        $updateData = $this->getUpdateData();

        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->$primaryKey;

        $this->put($endpoint, $updateData);
        $this->assertResponseOk();
        $this->seeJsonInDatabase($this->model->getTable(), $updateData);
    }

    /**
     * @param string $table
     * @param array  $data
     */
    protected function seeJsonInDatabase($table, array $data)
    {
        foreach ($data as &$each) {
            $each = json_encode($each);
        }
        $this->seeInDatabase($table, $data);
    }
}
