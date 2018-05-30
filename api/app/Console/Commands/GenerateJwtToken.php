<?php

namespace DentalSleepSolutions\Console\Commands;

use Carbon\Carbon;
use DentalSleepSolutions\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Console\Command;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use Illuminate\Contracts\Auth\Factory as Auth;

/**
 * CLI to generate JWT tokens with v_users IDs
 *
 * @see \ViewsCombineUsers::up
 */
class GenerateJwtToken extends Command
{
    const DATE_FORMAT = 'Y-m-d H:i:s';

    /** @var string */
    protected $signature = 'jwt:token
        {role : One of the following: admin, user, patient}
        {id : Role identifier}
        {--nbf|not-before= : DateTime before which the token is invalid}
        {--exp|expire= : DateTime from which the token is expired}
    ';

    /** @var string */
    protected $description = 'Generate JWT token for a user.';

    /** @var Auth */
    private $auth;

    /** @var JwtHelper */
    private $jwtHelper;

    public function __construct(Auth $auth, JwtHelper $jwtHelper)
    {
        parent::__construct();
        $this->auth = $auth;
        $this->jwtHelper = $jwtHelper;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function handle()
    {
        $role = $this->argument('role');
        $id = $this->argument('id');
        $notBefore = $this->option('not-before');
        $expire = $this->option('expire');

        if (!in_array($role, JwtHelper::ROLES)) {
            return;
        }

        if (!is_null($notBefore)) {
            $notBefore = Carbon::createFromFormat(self::DATE_FORMAT, $notBefore);
        }

        if (!is_null($expire)) {
            $expire = Carbon::createFromFormat(self::DATE_FORMAT, $expire);
        }

        /** @var Guard $guard */
        $guard = $this->auth->guard($role);
        /** @var Authenticatable $authenticatable */
        $authenticatable = $guard->loginUsingId($id);
        if (!$authenticatable) {
            return;
        }

        $token = $this->jwtHelper
            ->createToken([
                JwtHelper::CLAIM_ROLE_INDEX => $role,
                JwtHelper::CLAIM_ID_INDEX => $id
            ], $expire, $notBefore)
        ;

        $this->info($token);
    }
}
