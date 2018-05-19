<?php
namespace DentalSleepSolutions\Http\Middleware;

class JwtPatientAuthChainMiddleware extends JwtPatientAuthMiddleware
{
    /** @var bool */
    protected $fallsThrough = true;
}
