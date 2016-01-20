<?php

namespace DentalSleepSolutions\Eloquent;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

/**
 * Model representing combined dental_users & admin tables data
 * using v_users db view. The view isn't writable thus model
 * is made read-only by disabling saving via model events.
 *
 * @see self::boot
 */
class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    /**
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
            $q->where('email', $id)->orWhere('id', $id);
        })->first();
    }
}
