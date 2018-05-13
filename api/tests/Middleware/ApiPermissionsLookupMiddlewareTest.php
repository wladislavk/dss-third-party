<?php
namespace Tests\Api;

use Closure;
use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermission;
use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResource;
use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResourceGroup;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Models\User as UserView;
use DentalSleepSolutions\Http\Middleware\ApiPermissionsLookupMiddleware;
use DentalSleepSolutions\Http\Middleware\JwtAdminAuthChainMiddleware;
use DentalSleepSolutions\Http\Middleware\JwtPatientAuthMiddleware;
use DentalSleepSolutions\Http\Middleware\JwtUserAuthChainMiddleware;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Http\Response;
use Tests\TestCases\MiddlewareTestCase;

class ApiPermissionsLookupMiddlewareTest extends MiddlewareTestCase
{
    const ADMIN_PREFIX = 'a_';
    const USER_PREFIX = 'u_';
    const PATIENT_PREFIX = 'p_';

    protected $testMiddleware = [
        JwtAdminAuthChainMiddleware::class,
        JwtUserAuthChainMiddleware::class,
        JwtPatientAuthMiddleware::class,
        ApiPermissionsLookupMiddleware::class,
    ];

    /** @var UserView */
    private $users;

    /** @var Closure */
    private $adminResolver;

    /** @var Closure */
    private $userResolver;

    /** @var Closure */
    private $patientResolver;

    public function setUp()
    {
        parent::setUp();
        $this->users = $this->app->make(UserView::class);

        $noOp = function () {
            return null;
        };

        $this->adminResolver = $noOp;
        $this->userResolver = $noOp;
        $this->patientResolver = $noOp;
    }

    public function testNoResource()
    {
        $user = $this->newUser();
        $this->setModelResolvers(0, $user->userid, 0);

        $this->get(self::TEST_ROUTE);
        $this->assertResponseOk();
    }

    public function testUserNotAllowed()
    {
        $user = $this->newUser();
        $this->setModelResolvers(0, $user->userid, 0);

        $group = $this->newResourceGroup(1, 0);
        $this->newResource($group->id);

        $this->get(self::TEST_ROUTE);
        $this->assertResponseStatus(Response::HTTP_FORBIDDEN);
    }

    public function testUserAllowed()
    {
        $user = $this->newUser();
        $this->setModelResolvers(0, $user->userid, 0);

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
        $this->setModelResolvers(0, $user->userid, $patient->patientid);

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
        $this->setModelResolvers(0, $user->userid, $patient->patientid);

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
        $this->setModelResolvers(0, $user->userid, $patient->patientid);

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
        $this->setModelResolvers(0, $user->userid, $patient->patientid);

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
        $this->setModelResolvers(0, $user->userid, $patient->patientid);

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

    private function setModelResolvers($adminId, $userId, $patientId)
    {
        $this->adminResolver = function () use ($adminId) {
            $model = $this->users
                ->newQuery()
                ->find(self::ADMIN_PREFIX . $adminId)
            ;
            return $model;
        };
        $this->userResolver = function () use ($userId) {
            $model = $this->users
                ->newQuery()
                ->find(self::USER_PREFIX . $userId)
            ;
            return $model;
        };
        $this->patientResolver = function () use ($patientId) {
            $model = $this->users
                ->newQuery()
                ->find(self::PATIENT_PREFIX . $patientId)
            ;
            return $model;
        };
    }

    protected function createRequest(
        $uri,
        $method,
        $parameters = [],
        $cookies = [],
        $files = [],
        $server = [],
        $content = null
    )
    {
        /** @var Request */
        $request = parent::createRequest($uri, $method, $parameters, $cookies, $files, $server, $content);

        $request->setAdminResolver($this->adminResolver);
        $request->setPatientResolver($this->patientResolver);
        $user = call_user_func($this->userResolver);

        if ($user) {
            $this->be($user);
        }

        return $request;
    }
}
