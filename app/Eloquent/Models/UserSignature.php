<?php

namespace DentalSleepSolutions\Eloquent\Models;

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
}
