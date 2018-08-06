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
    const USER_ID = 1;
    const PATIENT_ID = 16;

    /** @var ApiPermissionResourceGroup */
    private $userGroup;

    /** @var ApiPermissionResourceGroup */
    private $patientGroup;

    /** @var ApiPermission */
    private $userPermission;

    /** @var ApiPermission */
    private $patientPermission;

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
        /*
        $this->userGroup = factory(ApiPermissionResourceGroup::class)->create([
            'authorize_per_user' => 1,
            'authorize_per_patient' => 0,
        ]);
        $this->patientGroup = factory(ApiPermissionResourceGroup::class)->create([
            'authorize_per_user' => 1,
            'authorize_per_patient' => 1,
        ]);
        $this->userPermission = factory(ApiPermission::class)->create([
            'group_id' => $this->userGroup->id,
            'doc_id' => self::USER_ID,
            'patient_id' => null,
        ]);
        $this->patientPermission = factory(ApiPermission::class)->create([
            'group_id' => $this->patientGroup->id,
            'doc_id' => self::USER_ID,
            'patient_id' => self::PATIENT_ID,
        ]);
        */
        $this->userPermission = factory(ApiPermission::class)->create([
            'doc_id' => self::USER_ID,
            'patient_id' => null,
        ]);
        $this->userGroup = ApiPermissionResourceGroup::find($this->userPermission->group_id);
        $this->patientPermission = factory(ApiPermission::class)->create([
            'doc_id' => self::USER_ID,
            'patient_id' => self::PATIENT_ID,
        ]);
        $this->patientGroup = ApiPermissionResourceGroup::find($this->patientPermission->group_id);
        $this->be(User::find(1));
    }

    protected function getStoreData()
    {
        $data = [
            'group_id' => $this->userGroup->id,
            'doc_id' => self::USER_ID,
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
        $storeData = $this->getStoreData();
        $this->post(self::ROUTE_PREFIX . $this->getRoute(), $storeData);
        $this->assertResponseOk();
        $this->seeInDatabase($this->model->getTable(), [
            'group_id' => $storeData['group_id'],
            'doc_id' => self::USER_ID,
            'patient_id' => null,
        ]);
    }

    public function testStoreWithPatient()
    {
        $storeData = $this->getStoreData();
        $storeData['patient_id'] = self::PATIENT_ID;
        $this->post(self::ROUTE_PREFIX . $this->getRoute(), $storeData);
        $this->assertResponseOk();
        $this->seeInDatabase($this->model->getTable(), [
            'group_id' => $storeData['group_id'],
            'doc_id' => self::USER_ID,
            'patient_id' => self::PATIENT_ID,
        ]);
    }

    public function testUpdate()
    {
        $testRecord = factory($this->getModel())->make(['doc_id' => self::USER_ID]);
        $updateData = $this->getUpdateData();
        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->$primaryKey;
        $this->put($endpoint, $updateData);
        $this->assertResponseStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testIndexAll()
    {
        $this->get(self::ROUTE_PREFIX . $this->nonStandardRoute);
        $this->assertResponseOk();
        $this->assertGreaterThanOrEqual(1, sizeof($this->getResponseData()));
        $this->dontSeeJson(['doc_id' => null]);
        $this->dontSeeJson(['patient_id' => self::PATIENT_ID]);
        $this->seeJson(['group_id' => $this->userGroup->id]);
        $this->dontSeeJson(['group_id' => $this->patientGroup->id]);
    }

    public function testIndexAllWithPatient()
    {
        $this->be(Patient::find(self::PATIENT_ID), 'patient');
        $this->get(self::ROUTE_PREFIX . $this->nonStandardRoute);
        $this->assertResponseOk();
        $this->assertGreaterThanOrEqual(1, sizeof($this->getResponseData()));
        $this->dontSeeJson(['doc_id' => null]);
        $this->dontSeeJson(['patient_id' => null]);
        $this->dontSeeJson(['group_id' => $this->userGroup->id]);
        $this->seeJson(['group_id' => $this->patientGroup->id]);
    }
}
