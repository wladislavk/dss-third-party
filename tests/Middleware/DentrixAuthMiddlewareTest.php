<?php
namespace Tests\Api;

use DentalSleepSolutions\Auth\DentrixAuth;
use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany;
use DentalSleepSolutions\Eloquent\Models\Dental\ExternalUser;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Http\Middleware\DentrixAuthMiddleware;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Structs\DentrixMiddlewareErrors;
use Illuminate\Http\Response;
use Tests\TestCases\MiddlewareTestCase;

class DentrixAuthMiddlewareTest extends MiddlewareTestCase
{
    const DATA_KEY = 'key';

    protected $testMiddleware = [
        DentrixAuthMiddleware::class
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
        $this->dentrixUser->user_id = $this->user->userid;
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
            DentrixAuthMiddleware::COMPANY_TOKEN_INDEX => '.'
        ]);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'message' => DentrixMiddlewareErrors::COMPANY_TOKEN_INVALID
        ]);
    }

    public function testNoUserToken()
    {
        $this->post(self::TEST_ROUTE, [
            DentrixAuthMiddleware::COMPANY_TOKEN_INDEX => $this->dentrixCompany->api_key,
        ]);

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
        $this->seeJson([
            'message' => DentrixMiddlewareErrors::USER_TOKEN_MISSING
        ]);
    }

    public function testInvalidUserToken()
    {
        $this->post(self::TEST_ROUTE, [
            DentrixAuthMiddleware::COMPANY_TOKEN_INDEX => $this->dentrixCompany->api_key,
            DentrixAuthMiddleware::USER_TOKEN_INDEX => '.',
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
            DentrixAuthMiddleware::COMPANY_TOKEN_INDEX => $this->dentrixCompany->api_key,
            DentrixAuthMiddleware::USER_TOKEN_INDEX => $this->dentrixUser->api_key,
        ]);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'message' => DentrixMiddlewareErrors::USER_NOT_FOUND
        ]);
    }

    public function testLoggedIn()
    {
        $this->post(self::TEST_ROUTE, [
            DentrixAuthMiddleware::COMPANY_TOKEN_INDEX => $this->dentrixCompany->api_key,
            DentrixAuthMiddleware::USER_TOKEN_INDEX => $this->dentrixUser->api_key,
        ]);

        $this->assertResponseOk();
        $this->seeJson([
            DentrixAuth::USER_MODEL_KEY => $this->user->{DentrixAuth::USER_MODEL_KEY}
        ]);
    }

    protected function requestHandler(Request $request)
    {
        return ApiResponse::responseOk('', $request->user());
    }
}
