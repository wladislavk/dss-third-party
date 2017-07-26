<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\UserSignature whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\UserSignature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\UserSignature whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\UserSignature whereSignatureJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\UserSignature whereUserId($value)
 */
class UserSignature extends AbstractModel
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

    const CREATED_AT = 'adddate';
}
