<?php

namespace DentalSleepSolutions\Console\Commands;

use Carbon\Carbon;
use DentalSleepSolutions\Auth\JwtAuth;
use Illuminate\Console\Command;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\Exceptions\JwtException;

/**
 * CLI to generate JWT tokens with v_users IDs
 *
 * @see \ViewsCombineUsers::up
 */
class GenerateJwtToken extends Command
{
    const ADMIN_PREFIX = 'a_';
    const PATIENT_PREFIX = 'p_';
    const DATE_FORMAT = 'Y-m-d H:i:s';

    /** @var string */
    protected $signature = 'jwt:token
        {id : User identifier - v_users id (a_X for admins, u_X for dental_users, p_X for dental_patients).}
        {--nbf|not-before= : DateTime before which the token is invalid}
        {--exp|expire= : DateTime from which the token is expired}
    ';

    /** @var string */
    protected $description = 'Generate JWT token for a user.';

    /** @var UserRepository */
    private $userRepository;

    /** @var JwtHelper */
    private $jwtHelper;

    public function __construct(
        UserRepository $userRepository,
        JwtHelper $jwtHelper
    )
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->jwtHelper = $jwtHelper;
    }

    public function handle()
    {
        $id = $this->argument('id');
        $notBefore = $this->option('not-before');
        $expire = $this->option('expire');

        $role = JwtAuth::ROLE_USER;

        if (substr($id, 0, strlen(self::ADMIN_PREFIX)) === self::ADMIN_PREFIX) {
            $role = JwtAuth::ROLE_ADMIN;
        }

        if (substr($id, 0, strlen(self::PATIENT_PREFIX)) === self::PATIENT_PREFIX) {
            $role = JwtAuth::ROLE_PATIENT;
        }

        if (!is_null($notBefore)) {
            $notBefore = Carbon::createFromFormat(self::DATE_FORMAT, $notBefore);
        }

        if (!is_null($expire)) {
            $expire = Carbon::createFromFormat(self::DATE_FORMAT, $expire);
        }

        /** @var User */
        $user = $this->userRepository
            ->findById($id)
        ;

        if (!$user) {
            return;
        }

        $token = $this->jwtHelper
            ->createToken([
                JwtAuth::CLAIM_ROLE_INDEX => $role,
                JwtAuth::CLAIM_ID_INDEX => $id
            ], $expire, $notBefore)
        ;

        $this->info($token);
    }
}
