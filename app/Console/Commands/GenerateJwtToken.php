<?php

namespace DentalSleepSolutions\Console\Commands;

use Illuminate\Console\Command;
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\Eloquent\Models\User;

/**
 * CLI to generate JWT tokens with v_users IDs
 *
 * @see \ViewsCombineUsers::up
 */
class GenerateJwtToken extends Command
{
    /** @var string */
    protected $signature = 'jwt:token {id : User identifier - either email or compound id (a_X for admins, u_X for dental_users).}';

    /** @var string */
    protected $description = 'Generate JWT token for a user.';

    /** @var UserRepository */
    private $userRepository;

    /** @var JWTAuth */
    private $auth;

    public function __construct(
        UserRepository $userRepository,
        JWTAuth $auth
    )
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->auth = $auth;
    }

    public function handle()
    {
        $id = $this->argument('id');
        /** @var User */
        $user = $this->userRepository->findById($id);
        $token = $this->tokenFromSingleModel($user);
        $this->info($token);
    }

    /**
     * @param User $model
     * @return string
     */
    private function tokenFromSingleModel(User $model)
    {
        return $this->auth->fromUser($model);
    }
}
