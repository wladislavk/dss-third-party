<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\AdvancedPainTmdExam;
use Tests\TestCases\ApiTestCase;

class AdvancedPainTmdExamsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return AdvancedPainTmdExam::class;
    }

    protected function getRoute()
    {
        return '/advanced-pain-tmd-exams';
    }

    protected function getStoreData()
    {
        $model = factory($this->getModel())->make();
        $data = $model->toArray();
        $data = [
            'cervical' => $data['cervical'],
            'morphology' => $data['morphology'],
            'cranial_nerve' => $data['cranial_nerve'],
            'occlusal' => $data['occlusal'],
            'other' => $data['other'],
        ];
        return $data;
    }

    protected function getUpdateData()
    {
        $model = factory($this->getModel())->make();
        $data = $model->toArray();
        $data = [
            'cervical' => $data['cervical'],
            'morphology' => $data['morphology'],
            'cranial_nerve' => $data['cranial_nerve'],
            'occlusal' => $data['occlusal'],
            'other' => $data['other'],
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
