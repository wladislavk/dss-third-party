<?php namespace Ds3\Admin\Repositories;

use Carbon\Carbon;
use Ds3\Eloquent\Auth\User;
use Ds3\Admin\Contracts\UserInterface;
use Illuminate\Support\Facades\Input;

class UserRepository  implements UserInterface {

    /**
     * @return all users
     */
    public function getAllUsers()
    {
        return User::all();
    }
    public function getUserWithStatus($status){}

    public function getUserByName($username)
    {

    }
    public function suspendUser($userId)
    {
        $user = User::find($userId);
        $user->suspended_date = Carbon::now();
        if($user->save())
        {
            return 'true';
        }else
        {
            return 'false';
        }
    }
    public function findUser($userId)
    {
        return User::find($userId);
    }
    public function updateUser($userId)
    {
        $user = User::find($userId);
        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');
        $user->email = Input::get('email');

        if($user->save())
        {
            return 'true';
        }else
        {
            return 'false';
        }
    }
    public function unSuspendUser($userId)
    {
        $user = User::find($userId);
        $user->suspended_date = null;

        if($user->save())
        {
            return 'true';
        }else
        {
            return 'false';
        }
    }

    public function deleteUser($userId)
    {
        $user = User::find($userId);

        if($user->delete())
        {
            return 'true';
        }else
        {
            return 'false';
        }
    }


} 