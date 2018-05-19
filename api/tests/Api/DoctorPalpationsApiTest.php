<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\DoctorPalpation;
use Tests\TestCases\ApiTestCase;

class DoctorPalpationsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return DoctorPalpation::class;
    }

    protected function getRoute()
    {
        return '/doctor-palpations';
    }

    protected function getStoreData()
    {
        $model = factory($this->getModel())->make();
        $data = $model->toArray();
        $data = [
            'palpationid' => $data['palpationid'],
            'sortby' => $data['sortby'],
        ];
        return $data;
    }

    protected function getUpdateData()
    {
        $model = factory($this->getModel())->make();
        $data = $model->toArray();
        $data = [
            'palpationid' => $data['palpationid'],
            'sortby' => $data['sortby'],
        ];
        return $data;
    }

    public function testIndex()
    {
        factory($this->getModel())->create([
            'doc_id' => 0,
        ]);
        $this->get(self::ROUTE_PREFIX . $this->getRoute(), $this->getStoreData());
        $this->assertResponseOk();
        $this->assertGreaterThan(0, count($this->getResponseData()));
    }

    public function testStore()
    {
        $storeData = $this->getStoreData();
        $this->post(self::ROUTE_PREFIX . $this->getRoute(), $storeData);
        $this->assertResponseOk();
        $this->seeInDatabase($this->model->getTable(), $storeData);
    }

    public function testUpdate()
    {
        $testRecord = factory($this->getModel())->create();
        $updateData = $this->getUpdateData();

        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->$primaryKey;

        $this->put($endpoint, $updateData);
        $this->assertResponseOk();
        $this->seeInDatabase($this->model->getTable(), $updateData);
    }
}
