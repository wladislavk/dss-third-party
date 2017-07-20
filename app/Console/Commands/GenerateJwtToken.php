<?php

namespace DentalSleepSolutions\Console\Commands;

use Illuminate\Console\Command;
use Tymon\JWTAuth\Facades\JWTAuth;
use DentalSleepSolutions\Eloquent\User;
use Symfony\Component\Console\Input\InputArgument;

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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * DSS can log a single user (FO/BO) or two users (BO "logged in as" FO).
         * This method can return more than one result, if the given ID has a separator "|"
         */
        $userData = User::findByIdOrEmail($this->argument('id'));

        if (!$userData) {
            exit(0);
        }

        /**
         * JWTAuth relies on user ID (with the default configuration) but it is not possible to generate a payload
         * with a combined approach. As a workaround, the ID of a single model will be altered to pass along the
         * list of IDs needed for "logged in as".
         */
        $userModel = $userData[0];

        if (isset($userData[1])) {
            $userModel->id = "{$userData[0]->id}|{$userData[1]->id}";
        }

        exit(JWTAuth::fromUser($userModel));
    }
}
