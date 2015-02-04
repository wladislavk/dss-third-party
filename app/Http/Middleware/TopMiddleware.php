<?php namespace Ds3\Http\Middleware;

use Closure;

use Ds3\Http\Controllers\TopController;

class TopMiddleware {

	public function __construct(TopController $controller)
	{
		$this->controller = $controller;
	}

	public function handle($request, Closure $next)
	{
		$top = $this->controller->index($request);

		if (is_array($top)) {
			$request->merge($top);
		} else {
			return $top;
		}

		$response = $next($request);

		return $response;
	}

}
