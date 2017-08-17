<?php

namespace DentalSleepSolutions\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use DentalSleepSolutions\Helpers\JwtHelper;
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
    /** @var string */
    protected $signature = 'jwt:token
        {id : User identifier - v_users id (a_X for admins, u_X for dental_users).}
        {--nbf|not-before= : DateTime before which the token is invalid}
        {--exp|expire= : DateTime from which the token is expired}
    ';

    /** @var string */
    protected $description = 'Generate JWT token for a user.';

    /** @var UserRepository */
    private $userRepository;

    /** @var JwtHelper */
    private $jwtHelper;

    /** @var Carbon */
    private $carbon;

    public function __construct(
        UserRepository $userRepository,
        JwtHelper $jwtHelper,
        Carbon $carbon
    )
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->jwtHelper = $jwtHelper;
        $this->carbon = $carbon;
    }

    public function handle()
    {
        $id = $this->argument('id');
        $notBefore = $this->option('not-before');
        $expire = $this->option('expire');

        $role = 'User';

        if (substr($id, 0, 2) === 'a_') {
            $role = 'Admin';
        }

        if (!is_null($notBefore)) {
            $this->carbon->setTimeFromTimeString($notBefore);
            $notBefore = $this->carbon->getTimestamp();
        }

        if (!is_null($expire)) {
            $this->carbon->setTimeFromTimeString($expire);
            $expire = $this->carbon->getTimestamp();
        }

        /** @var User */
        $user = $this->userRepository
            ->findById($id)
        ;

        if (!$user) {
            return;
        }

        try {
            $token = $this->jwtHelper
                ->createToken([
                    'role' => $role,
                    'id' => $id
                ], $expire, $notBefore)
            ;
            $this->info($token);
        } catch (JwtException $e) {
            // Fall through
        }
    }
}
