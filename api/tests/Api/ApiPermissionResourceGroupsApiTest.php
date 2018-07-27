<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResourceGroup;
use Illuminate\Http\Response;
use Tests\TestCases\ApiTestCase;

class ApiPermissionResourceGroupsApiTest extends ApiTestCase
{
    /** @var string */
    private $nonStandardRoute = '/api-permission/groups';

    protected function getModel()
    {
        return ApiPermissionResourceGroup::class;
    }

    protected function getRoute()
    {
        return '/api-permission/resource-groups';
    }

    protected function getStoreData()
    {
        /** @var ApiPermissionResourceGroup $model */
        $model = factory($this->getModel())->make();
        $data = [
            'slug' => $model->slug,
            'name' => $model->name,
            'authorize_per_user' => $model->authorize_per_user,
            'authorize_per_patient' => $model->authorize_per_patient,
        ];
        return $data;
    }

    protected function getUpdateData()
    {
        return $this->getStoreData();
    }

    public function testStore()
    {
        /** @var Admin $admin */
        $admin = factory(Admin::class)->create();
        $this->be($admin, 'admin');
        $storeData = $this->getStoreData();
        $this->post(self::ROUTE_PREFIX . $this->getRoute(), $storeData);
        $this->assertResponseOk();
        $this->seeInDatabase($this->model->getTable(), [
            'slug' => $storeData['slug'],
            'name' => $storeData['name'],
            'authorize_per_user' => $storeData['authorize_per_user'],
            'authorize_per_patient' => $storeData['authorize_per_patient'],
            'created_by' => $admin->adminid,
        ]);
    }

    public function testUpdate()
    {
        /** @var Admin $admin */
        $admin = factory(Admin::class)->create();
        $this->be($admin, 'admin');
        $testRecord = factory($this->getModel())->make();
        $updateData = $this->getUpdateData();
        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->$primaryKey;
        $this->put($endpoint, $updateData);
        $this->assertResponseStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testGroups()
    {
        $models = factory($this->getModel(), 5)->create();
        $this->get(self::ROUTE_PREFIX . $this->nonStandardRoute);
        $this->assertResponseOk();
        $this->assertGreaterThanOrEqual(5, sizeof($this->getResponseData()));
        foreach ($models->toArray() as $model) {
            $this->seeJson($model);
        }
    }
}
