<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany;
use Tests\TestCases\ModelAwareApiTestCase;

class ExternalCompaniesApiTest extends ModelAwareApiTestCase
{
    protected function getModel()
    {
        return ExternalCompany::class;
    }

    protected function getRoute()
    {
        return '/external-companies';
    }

    protected function getUpdateData()
    {
        return [
            'api_key' => $this->faker->sha1,
        ];
    }

    public function testShow()
    {
        $testRecord = $this->modelFactory()[0];

        $primaryKey = $this->getModelKey();
        $endpoint = $this->getRoutePrefix() . $this->getRoute() . '/' . $testRecord->$primaryKey;
        $this->get($endpoint);
        $this->assertResponseOk();
        $data = $this->getResponseData();
        $this->assertEquals($testRecord->$primaryKey, $data[$primaryKey]);
    }

    public function testUpdate()
    {
        $testRecord = $this->modelFactory()[0];

        $primaryKey = $this->getModelKey();
        $endpoint = $this->getRoutePrefix() . $this->getRoute() . '/' . $testRecord->$primaryKey;

        $updateData = $this->getUpdateData();
        $this->put($endpoint, $updateData);
        $this->assertResponseOk();
        $this->seeInDatabase($this->model->getTable(), $updateData);
    }

    public function testDestroy()
    {
        $testRecord = $this->modelFactory()[0];

        $primaryKey = $this->getModelKey();
        $endpoint = $this->getRoutePrefix() . $this->getRoute() . '/' . $testRecord->$primaryKey;

        $this->delete($endpoint);
        $this->assertResponseOk();
        $this->notSeeInDatabase($this->model->getTable(), [$primaryKey => $testRecord->$primaryKey]);
    }
}
