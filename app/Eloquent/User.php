<?php

namespace DentalSleepSolutions\Eloquent;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

/**
 * @DSS\Manual
 *
 * Model representing combined dental_users & admin tables data
 * using v_users db view. The view isn't writable thus model
 * is made read-only by disabling saving via model events.
 *
 * @see self::boot
 * @mixin \Eloquent
 */
class User extends AbstractModel implements AuthenticatableContract
{
    use Authenticatable;

    const USER_PREFIX = 'u_';
    const ADMIN_PREFIX = 'a_';

    /**
     * @todo View generated on database/migrations/2015_12_22_203443_views_combine_users.php
     * @todo View altered in AWS-19-Request-Token
     *
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'v_users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'salt'];

    /**
     * Boot the model and make it read-only via eloquent events.
     * @link https://laravel.com/docs/5.1/eloquent#events
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function () {
            return false;
        });
    }

    public static function findByIdOrEmail($id)
    {
        return self::where(function ($q) use ($id) {
            $id = explode('|', $id);
            $q->whereIn('email', $id)->orWhereIn('id', $id);
        })
            ->orderBy('id', 'ASC')
            ->get()
        ;
    }
}
