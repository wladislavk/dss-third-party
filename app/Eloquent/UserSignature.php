<?php

namespace DentalSleepSolutions\Eloquent;

use Illuminate\Database\Eloquent\Model;

class UserSignature extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_user_signatures';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['user_id', 'signature_json', 'adddate', 'ip_address'];

    /**
     * @var bool
     */
    public $timestamps = false;
}
