<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\UserSignature as Resource;
use DentalSleepSolutions\Contracts\Repositories\UserSignatures as Repository;

class UserSignature extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_user_signatures';

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

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
    public static function addUpdate($user_id, $signature_json, $ip_address)
    {
        if ($updated = self::where('user_id', $user_id)->first()) {
            self::where('user_id', $user_id)
                ->update([
                    'signature_json'=>$signature_json,
                    'ip_address' =>  $ip_address,
                ]);

            return $updated->id;
        }

        $new = new UserSignature();
        $new->user_id = $user_id;
        $new->signature_json = $signature_json;
        $new->adddate = Carbon::now();
        $new->ip_address = $ip_address;
        $new->save();

        return $new->id;
    }
}
