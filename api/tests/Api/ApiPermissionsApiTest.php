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

    /** @var ApiPermissionResourceGroup */
    private $userBasedGroup;

    /** @var ApiPermissionResourceGroup */
    private $patientBasedGroup;

    /** @var ApiPermission */
    private $userBasedPermission;

    /** @var ApiPermission */
    private $patientBasedPermission;

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
        $this->userBasedGroup = factory(ApiPermissionResourceGroup::class)->create([
            'authorize_per_user' => 1,
            'authorize_per_patient' => 0,
        ]);
        $this->patientBasedGroup = factory(ApiPermissionResourceGroup::class)->create([
            'authorize_per_user' => 1,
            'authorize_per_patient' => 1,
        ]);
        $this->userBasedPermission = factory(ApiPermission::class)->create([
            'group_id' => $this->userBasedGroup->id,
            'doc_id' => $this->userModel->userid,
            'patient_id' => null,
        ]);
        $this->patientBasedPermission = factory(ApiPermission::class)->create([
            'group_id' => $this->patientBasedGroup->id,
            'doc_id' => $this->userModel->userid,
            'patient_id' => $this->patientModel->patientid,
        ]);
    }

    protected function getStoreData()
    {
        $data = [
            'group_id' => $this->userBasedGroup->id,
            'doc_id' => $this->userModel->userid,
            'patient_id' => null,
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
            'patient_id' => null,
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
        $this->be($this->userModel);
        $this->get(self::ROUTE_PREFIX . $this->nonStandardRoute);
        $this->assertResponseOk();
        $this->assertGreaterThanOrEqual(1, sizeof($this->getResponseData()));
        $this->dontSeeJson(['doc_id' => null]);
        $this->dontSeeJson(['patient_id' => $this->patientModel->patientid]);
        $this->seeJson(['group_id' => $this->userBasedGroup->id]);
        $this->dontSeeJson(['group_id' => $this->patientBasedGroup->id]);
    }

    public function testIndexAllWithPatient()
    {
        $this->be($this->userModel);
        $this->be($this->patientModel, 'patient');
        $this->get(self::ROUTE_PREFIX . $this->nonStandardRoute);
        $this->assertResponseOk();
        $this->assertGreaterThanOrEqual(1, sizeof($this->getResponseData()));
        $this->dontSeeJson(['doc_id' => null]);
        $this->dontSeeJson(['patient_id' => null]);
        $this->dontSeeJson(['group_id' => $this->userBasedGroup->id]);
        $this->seeJson(['group_id' => $this->patientBasedGroup->id]);
    }
}
