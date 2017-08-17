<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Exceptions\JWT\EmptyTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidPayloadException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Exceptions\JWT\InactiveTokenException;
use DentalSleepSolutions\Exceptions\JWT\ExpiredTokenException;
use DentalSleepSolutions\Exceptions\Auth\UserNotFoundException;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Structs\JwtMiddlewareErrors as MiddlewareErrors;
use DentalSleepSolutions\Http\Requests\Request;

class JwtUserAuthMiddleware
{
    /** @var JwtAuth */
    private $auth;

    public function __construct(JwtAuth $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, Closure $next)
    {
        $this->auth->setRequest($request);

        if ($request->admin()) {
            $request = $this->handleSudo($request);
            return $next($request);
        }

        try {
            $this->auth->toUser();
        } catch (EmptyTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_MISSING, 400);
        } catch (InvalidTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_INVALID, 400);
        } catch (InactiveTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_INACTIVE, 422);
        } catch (ExpiredTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_EXPIRED, 422);
        } catch (InvalidPayloadException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_INVALID, 422);
        } catch (UserNotFoundException $e) {
            return ApiResponse::responseError(MiddlewareErrors::USER_NOT_FOUND, 422);
        }

        $request->setUserResolver(function () {
            $user = $this->auth
                ->guard('User')
                ->user()
            ;
            return $user;
        });

        return $next($request);
    }

    /**
     * @param Request $request
     * @return Request
     */
    private function handleSudo(Request $request)
    {
        $sudoId = $request->input('sudo_as', '');

        $data = $request->all();
        unset($data['sudo_as']);
        $request->replace($data);

        $user = $this->auth
            ->guard('User')
            ->once([
                'userid' => $sudoId
            ])
        ;

        if (!$user) {
            return $request;
        }

        $request->setUserResolver(function () {
            $user = $this->auth
                ->guard('User')
                ->user()
            ;
            return $user;
        });

        return $request;
    }
}
