<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermission;
use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResource;
use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResourceGroup;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Http\Middleware\ApiPermissionsLookupMiddleware;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use Illuminate\Http\Response;
use Tests\TestCases\MiddlewareTestCase;

class ApiPermissionsLookupMiddlewareTest extends MiddlewareTestCase
{
    protected $testMiddleware = [
        ApiPermissionsLookupMiddleware::class,
    ];

    public function setUp()
    {
        parent::setUp();
    }

    public function testNoResource()
    {
        $user = $this->newUser();
        $this->be($user, JwtHelper::ROLE_USER);

        $this->get(self::TEST_ROUTE);
        $this->assertResponseOk();
    }

    public function testUserNotAllowed()
    {
        $user = $this->newUser();
        $this->be($user, JwtHelper::ROLE_USER);

        $group = $this->newResourceGroup(1, 0);
        $this->newResource($group->id);

        $this->get(self::TEST_ROUTE);
        $this->assertResponseStatus(Response::HTTP_FORBIDDEN);
    }

    public function testUserAllowed()
    {
        $user = $this->newUser();
        $this->be($user, JwtHelper::ROLE_USER);

        $group = $this->newResourceGroup(1, 0);
        $this->newResource($group->id);
        $this->newPermission($group->id, $user->userid, 0);

        $this->get(self::TEST_ROUTE);
        $this->assertResponseOk();
    }

    public function testPatientNotAllowed()
    {
        $user = $this->newUser();
        $patient = $this->newPatient($user->userid);
        $this->be($user, JwtHelper::ROLE_USER);
        $this->be($patient, JwtHelper::ROLE_PATIENT);

        $group = $this->newResourceGroup(1, 1);
        $this->newResource($group->id);
        $this->newPermission($group->id, $user->userid, 0);

        $this->get(self::TEST_ROUTE);
        $this->assertResponseStatus(Response::HTTP_FORBIDDEN);
    }

    public function testPatientAllowed()
    {
        $user = $this->newUser();
        $patient = $this->newPatient($user->userid);
        $this->be($user, JwtHelper::ROLE_USER);
        $this->be($patient, JwtHelper::ROLE_PATIENT);

        $group = $this->newResourceGroup(1, 1);
        $this->newResource($group->id);
        $this->newPermission($group->id, $user->userid, 0);
        $this->newPermission($group->id, 0, $patient->patientid);

        $this->get(self::TEST_ROUTE);
        $this->assertResponseOk();
    }

    public function testShadowPatientNotAllowed()
    {
        $user = $this->newUser();
        $parentPatient = $this->newPatient($user->userid);
        $patient = $this->newPatient(0, $parentPatient->patientid);
        $this->be($user, JwtHelper::ROLE_USER);
        $this->be($patient, JwtHelper::ROLE_PATIENT);

        $group = $this->newResourceGroup(1, 1);
        $this->newResource($group->id);
        $this->newPermission($group->id, $user->userid, 0);

        $this->get(self::TEST_ROUTE);
        $this->assertResponseStatus(Response::HTTP_FORBIDDEN);
    }

    public function testShadowPatientAllowed()
    {
        $user = $this->newUser();
        $parentPatient = $this->newPatient($user->userid);
        $patient = $this->newPatient(0, $parentPatient->patientid);
        $this->be($user, JwtHelper::ROLE_USER);
        $this->be($patient, JwtHelper::ROLE_PATIENT);

        $group = $this->newResourceGroup(1, 1);
        $this->newResource($group->id);
        $this->newPermission($group->id, $user->userid, 0);
        $this->newPermission($group->id, 0, $patient->patientid);

        $this->get(self::TEST_ROUTE);
        $this->assertResponseOk();
    }

    public function testNoShadowPatient()
    {
        $user = $this->newUser();
        $patient = $this->newPatient(0);
        $this->be($user, JwtHelper::ROLE_USER);
        $this->be($patient, JwtHelper::ROLE_PATIENT);

        $group = $this->newResourceGroup(1, 1);
        $this->newResource($group->id);
        $this->newPermission($group->id, $user->userid, 0);

        $this->get(self::TEST_ROUTE);
        $this->assertResponseStatus(Response::HTTP_FORBIDDEN);
    }

    private function newPermission($groupId, $docId, $patientId)
    {
        $permission = factory(ApiPermission::class)->create([
            'group_id' => $groupId,
            'doc_id' => $docId,
            'patient_id' => $patientId,
        ]);
        return $permission;
    }

    private function newResource($groupId)
    {
        $resource = factory(ApiPermissionResource::class)->create([
            'group_id' => $groupId,
            'route' => self::TEST_ROUTE,
        ]);
        return $resource;
    }

    private function newResourceGroup($authorizePerUser, $authorizePerPatient)
    {
        $group = factory(ApiPermissionResourceGroup::class)->create([
            'authorize_per_user' => $authorizePerUser,
            'authorize_per_patient' => $authorizePerPatient,
        ]);
        return $group;
    }

    private function newPatient($docId, $parentId = 0)
    {
        $patient = factory(Patient::class)->create([
            'docid' => $docId,
            'parent_patientid' => $parentId,
        ]);
        return $patient;
    }

    private function newUser()
    {
        $user = factory(User::class)->create([
            'docid' => 0,
        ]);
        return $user;
    }
}
