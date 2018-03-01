<?php

namespace DentalSleepSolutions\Eloquent\Models;

use DentalSleepSolutions\Contracts\UserInterface;
use DentalSleepSolutions\Eloquent\Traits\UserTrait;
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
 * @property string $id
 * @property int|null $userid
 * @property int|null $docid
 * @property string|null $ip_address
 * @mixin \Eloquent
 */
class User extends AbstractModel implements AuthenticatableContract, UserInterface
{
    use Authenticatable, UserTrait;

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

    public $incrementing = false;

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
}
