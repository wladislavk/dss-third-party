<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany;
use DentalSleepSolutions\Eloquent\Models\Dental\ExternalUser;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Http\Middleware\DentrixAuthenticationMiddleware;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Services\Auth\Guard;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use DentalSleepSolutions\Structs\DentrixMiddlewareErrors;
use Illuminate\Http\Response;
use Tests\TestCases\MiddlewareTestCase;
use Illuminate\Contracts\Auth\Factory as Auth;

class DentrixAuthenticationMiddlewareTest extends MiddlewareTestCase
{
    protected $testMiddleware = [
        DentrixAuthenticationMiddleware::class
    ];

    /** @var ExternalCompany */
    private $dentrixCompany;

    /** @var ExternalUser */
    private $dentrixUser;

    /** @var User */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->dentrixCompany = factory(ExternalCompany::class)->create();
        $this->dentrixUser = factory(ExternalUser::class)->make();
        $this->dentrixUser->{DentrixAuthenticationMiddleware::USER_MODEL_KEY} = $this->user->getAuthIdentifier();
        $this->dentrixUser->save();
    }

    public function testNoCompanyToken()
    {
        $this->post(self::TEST_ROUTE, []);

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
        $this->seeJson([
            'message' => DentrixMiddlewareErrors::COMPANY_TOKEN_MISSING
        ]);
    }

    public function testInvalidCompanyToken()
    {
        $this->post(self::TEST_ROUTE, [
            DentrixAuthenticationMiddleware::COMPANY_TOKEN_INDEX => '.'
        ]);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'message' => DentrixMiddlewareErrors::COMPANY_TOKEN_INVALID
        ]);
    }

    public function testNoUserToken()
    {
        $this->post(self::TEST_ROUTE, [
            DentrixAuthenticationMiddleware::COMPANY_TOKEN_INDEX => $this->dentrixCompany->getAuthPassword(),
        ]);

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
        $this->seeJson([
            'message' => DentrixMiddlewareErrors::USER_TOKEN_MISSING
        ]);
    }

    public function testInvalidUserToken()
    {
        $this->post(self::TEST_ROUTE, [
            DentrixAuthenticationMiddleware::COMPANY_TOKEN_INDEX => $this->dentrixCompany->getAuthPassword(),
            DentrixAuthenticationMiddleware::USER_TOKEN_INDEX => '.',
        ]);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'message' => DentrixMiddlewareErrors::USER_TOKEN_INVALID
        ]);
    }

    public function testUserNotFound()
    {
        $this->user->delete();

        $this->post(self::TEST_ROUTE, [
            DentrixAuthenticationMiddleware::COMPANY_TOKEN_INDEX => $this->dentrixCompany->getAuthPassword(),
            DentrixAuthenticationMiddleware::USER_TOKEN_INDEX => $this->dentrixUser->getAuthPassword(),
        ]);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'message' => DentrixMiddlewareErrors::USER_NOT_FOUND
        ]);
    }

    public function testLoggedIn()
    {
        $this->post(self::TEST_ROUTE, [
            DentrixAuthenticationMiddleware::COMPANY_TOKEN_INDEX => $this->dentrixCompany->getAuthPassword(),
            DentrixAuthenticationMiddleware::USER_TOKEN_INDEX => $this->dentrixUser->getAuthPassword(),
        ]);

        $this->assertResponseOk();
        $this->seeJson([
            $this->user->getAuthIdentifierName() => $this->user->getAuthIdentifier(),
        ]);
    }

    protected function requestHandler(Request $request)
    {
        /** @var Auth $auth */
        $auth = $this->app['auth'];
        /** @var Guard $guard */
        $guard = $auth->guard(JwtHelper::ROLE_USER);
        return ApiResponse::responseOk('', $guard->user());
    }
}
