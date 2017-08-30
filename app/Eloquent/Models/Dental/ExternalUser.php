<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\DentrixAuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

/**
 * @SWG\Definition(
 *     definition="ExternalUser",
 *     type="object",
 *     @SWG\Property(property="user", ref="#/definitions/User")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\ExternalUser
 *
 * @property int $id
 * @property int $user_id
 * @property string $api_key
 * @property string $valid_from
 * @property string $valid_to
 * @property int $enabled
 * @property int $created_by
 * @property int $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \DentalSleepSolutions\Eloquent\Models\Dental\User $user
 */
class ExternalUser extends AbstractModel implements AuthenticatableContract
{
    use DentrixAuthenticatableTrait;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_external_users';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'userid');
    }
}
