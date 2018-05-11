<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\PainTmdExam;
use Tests\TestCases\ApiTestCase;

class PainTmdExamsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return PainTmdExam::class;
    }

    protected function getRoute()
    {
        return '/pain-tmd-exams';
    }

    protected function getStoreData()
    {
        $model = factory($this->getModel())->make();
        $data = $model->toArray();
        $data = [
            'description' => $data['description'],
            'pain' => $data['pain'],
            'symptom_review' => $data['symptom_review'],
            'symptoms' => $data['symptoms'],
            'headaches' => $data['headaches'],
        ];
        return $data;
    }

    protected function getUpdateData()
    {
        $model = factory($this->getModel())->make();
        $data = $model->toArray();
        $data = [
            'description' => $data['description'],
            'pain' => $data['pain'],
            'symptom_review' => $data['symptom_review'],
            'symptoms' => $data['symptoms'],
            'headaches' => $data['headaches'],
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
