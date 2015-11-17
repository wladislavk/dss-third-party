<?php

namespace DentalSleepSolutions;

use Illuminate\Database\Eloquent\Model;

class UserSignatures extends Model
{

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable =
        ['user_id',
        'signature_json',
        'adddate',
        'ip_address',];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_user_signatures';

    /**
     * @var bool
     */
    public $timestamps = false;


}
