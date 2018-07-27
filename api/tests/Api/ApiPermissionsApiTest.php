<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermission;
use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResourceGroup;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use Illuminate\Http\Response;
use Tests\TestCases\ApiTestCase;

class ApiPermissionsApiTest extends ApiTestCase
{
    /** @var User */
    private $userModel;

    /** @var Patient */
    private $patientModel;

    /** @var ApiPermissionResourceGroup[] */
    private $userBasedGroups;

    /** @var ApiPermissionResourceGroup[] */
    private $patientBasedGroups;

    /** @var string */
    private $nonStandardRoute = '/api-permission/all';

    protected function getModel()
    {
        return ApiPermission::class;
    }

    protected function getRoute()
    {
        return '/api-permission/permissions';
    }

    public function setUp()
    {
        parent::setUp();
        $this->userModel = factory(User::class)->create(['docid' => 0]);
        $this->patientModel = factory(Patient::class)->create(['docid' => $this->userModel->userid]);
        $this->userBasedGroups = factory(ApiPermissionResourceGroup::class, 3)->create([
            'authorize_per_user' => 1,
            'authorize_per_patient' => 0,
        ]);
        $this->patientBasedGroups = factory(ApiPermissionResourceGroup::class, 3)->create([
            'authorize_per_user' => 1,
            'authorize_per_patient' => 1,
        ]);
    }

    protected function getStoreData()
    {
        $model = $this->userBasedGroups[0];
        $data = [
            'group_id' => $model->id,
            'doc_id' => $this->userModel->userid,
            'patient_id' => 0,
        ];
        return $data;
    }

    protected function getUpdateData()
    {
        return $this->getStoreData();
    }

    public function testStore()
    {
        $this->be($this->userModel);
        $storeData = $this->getStoreData();
        $this->post(self::ROUTE_PREFIX . $this->getRoute(), $storeData);
        $this->assertResponseOk();
        $this->seeInDatabase($this->model->getTable(), [
            'group_id' => $storeData['group_id'],
            'doc_id' => $this->userModel->userid,
            'patient_id' => 0,
        ]);
    }

    public function testStoreWithPatient()
    {
        $this->be($this->userModel);
        $storeData = $this->getStoreData();
        $storeData['patient_id'] = $this->patientModel->patientid;
        $this->post(self::ROUTE_PREFIX . $this->getRoute(), $storeData);
        $this->assertResponseOk();
        $this->seeInDatabase($this->model->getTable(), [
            'group_id' => $storeData['group_id'],
            'doc_id' => $this->userModel->userid,
            'patient_id' => $this->patientModel->patientid,
        ]);
    }

    public function testUpdate()
    {
        $this->be($this->userModel);
        $testRecord = factory($this->getModel())->make(['doc_id' => $this->userModel->userid]);
        $updateData = $this->getUpdateData();
        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->$primaryKey;
        $this->put($endpoint, $updateData);
        $this->assertResponseStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testIndexAll()
    {
        $this->createPermissions();
        $this->be($this->userModel);
        $this->get(self::ROUTE_PREFIX . $this->nonStandardRoute);
        $this->assertResponseOk();
        $this->assertGreaterThanOrEqual(3, sizeof($this->getResponseData()));
        $this->dontSeeJson(['doc_id' => 0]);
        $this->dontSeeJson(['patient_id' => $this->patientModel->patientid]);
        foreach ($this->userBasedGroups as $model) {
            $this->seeJson(['group_id' => $model->id]);
        }
        foreach ($this->patientBasedGroups as $model) {
            $this->dontSeeJson(['group_id' => $model->id]);
        }
    }

    public function testIndexAllWithPatient()
    {
        $this->createPermissions();
        $this->be($this->userModel);
        $this->be($this->patientModel, 'patient');
        $this->get(self::ROUTE_PREFIX . $this->nonStandardRoute);
        $this->assertResponseOk();
        $this->assertGreaterThanOrEqual(3, sizeof($this->getResponseData()));
        $this->dontSeeJson(['doc_id' => 0]);
        $this->dontSeeJson(['patient_id' => 0]);
        foreach ($this->userBasedGroups as $model) {
            $this->dontSeeJson(['group_id' => $model->id]);
        }
        foreach ($this->patientBasedGroups as $model) {
            $this->seeJson(['group_id' => $model->id]);
        }
    }

    private function createPermissions()
    {
        foreach ($this->userBasedGroups as $model) {
            factory(ApiPermission::class)->create([
                'group_id' => $model->id,
                'doc_id' => $this->userModel->userid,
                'patient_id' => 0,
            ]);
        }
        foreach ($this->patientBasedGroups as $model) {
            factory(ApiPermission::class)->create([
                'group_id' => $model->id,
                'doc_id' => $this->userModel->userid,
                'patient_id' => $this->patientModel->patientid,
            ]);
        }
    }
}
