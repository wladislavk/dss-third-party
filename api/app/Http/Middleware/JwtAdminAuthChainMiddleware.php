<?php
namespace DentalSleepSolutions\Http\Middleware;

class JwtAdminAuthChainMiddleware extends JwtAdminAuthMiddleware
{
    /** @var bool */
    protected $fallsThrough = true;
}
