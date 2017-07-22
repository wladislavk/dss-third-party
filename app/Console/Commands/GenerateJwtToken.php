<?php

namespace DentalSleepSolutions\Console\Commands;

use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use Illuminate\Console\Command;
use Tymon\JWTAuth\Facades\JWTAuth;
use DentalSleepSolutions\Eloquent\Models\User;

/**
 * This is a helper command for easy generating JWT tokens from
 * cli, given either user's email or combined id (both admin
 * and dental_users tables) - usable from the legacy code.
 *
 * @see \ViewsCombineUsers::up
 */
class GenerateJwtToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jwt:token {id : User identifier - either email or compound id (a_X for admins, u_X for dental_users).}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate JWT token for a user.';

    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = $this->userRepository->findByIdOrEmail($this->argument('id'));

        if (!$user) {
            exit(0);
        }

        exit(JWTAuth::fromUser($user));
    }
}
