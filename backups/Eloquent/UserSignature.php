<?php

namespace DentalSleepSolutions\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *     definition="UserSignature",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="user_id", type="integer"),
 *     @SWG\Property(property="signature_json", type="string"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\UserSignature
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $signature_json
 * @property string|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\UserSignature whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\UserSignature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\UserSignature whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\UserSignature whereSignatureJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\UserSignature whereUserId($value)
 * @mixin \Eloquent
 */
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
