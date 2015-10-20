<?php
namespace DentalSleepSolutions;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password',
        'status', 'adddate', 'ip_address',
        'salt', 'recover_hash', 'recover_time',
        'admin_access', 'last_accessed_date', 'claim_margin_top',
        'claim_margin_left', 'email', 'first_name', 'last_name'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'adminid';
}
