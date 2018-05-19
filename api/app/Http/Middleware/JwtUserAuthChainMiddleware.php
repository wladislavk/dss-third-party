<?php
namespace DentalSleepSolutions\Http\Middleware;

class JwtUserAuthChainMiddleware extends JwtUserAuthMiddleware
{
    /** @var bool */
    protected $fallsThrough = true;
}
