<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResource;
use Illuminate\Http\Response;
use Tests\TestCases\ApiTestCase;

class ApiPermissionResourcesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return ApiPermissionResource::class;
    }

    protected function getRoute()
    {
        return '/api-permission/resources';
    }

    protected function getStoreData()
    {
        /** @var ApiPermissionResource $model */
        $model = factory($this->getModel())->make();
        $data = [
            'group_id' => $model->group_id,
            'slug' => $model->slug,
            'route' => $model->route,
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
            'route' => $storeData['route'],
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
}
