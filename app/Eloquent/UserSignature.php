<?php

namespace DentalSleepSolutions\Eloquent;

use Carbon\Carbon;
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
    protected $fillable = ['id', 'user_id', 'signature_json', 'adddate', 'ip_address'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param $user_id
     * @return mixed
     */
    public static function formUser($user_id)
    {
        return self::where('user_id', $user_id)->first();
    }

    /**
     * @param $user_id
     * @param $signature_json
     * @param $ip_address
     * @return mixed
     */
    public static function add($user_id, $signature_json, $ip_address)
    {
        $new = new UserSignature();
        $new->user_id = $user_id;
        $new->signature_json = $signature_json;
        $new->adddate = Carbon::now();
        $new->ip_address = $ip_address;
        $new->save();

        return $new->id;
    }
}
