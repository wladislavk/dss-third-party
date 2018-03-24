<?php

namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ApiLogRepository;
use DentalSleepSolutions\Http\Requests\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class ApiLogMiddleware
{
    /** @var ApiLogRepository */
    private $apiLogRepository;

    public function __construct(ApiLogRepository $apiLogRepository)
    {
        $this->apiLogRepository = $apiLogRepository;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws ValidatorException
     */
    public function handle(Request $request, Closure $next)
    {
        $this->apiLogRepository->create([
            'method' => $request->method(),
            'route' => $request->path(),
            'payload' => json_encode($request->all()),
        ]);

        return $next($request);
    }
}
