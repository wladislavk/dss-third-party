<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\DentrixAuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

/**
 * @SWG\Definition(
 *     definition="ExternalCompany",
 *     type="object",
 *     @SWG\Property(property="users", type="array", @SWG\Items(ref="#/definitions/User"))
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\ExternalCompany
 *
 * @mixin \Eloquent
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Models\Dental\User[] $users
 * @mixin \Eloquent
 */
class ExternalCompany extends AbstractModel implements AuthenticatableContract
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
    protected $table = 'dental_external_companies';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function users() {
        return $this->hasManyThrough(User::class, ExternalCompanyUser::class, 'user_id', 'userid');
    }

    /**
     * @return string
     */
    public function getAuthIdentifierName(): string
    {
        return 'id';
    }
}
