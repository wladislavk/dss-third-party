<?php

namespace DentalSleepSolutions\Eloquent;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\Payer as Resource;
use DentalSleepSolutions\Contracts\Repositories\Payers as Repository;

/**
 * @property string $payer_id           Eligible payer unique identifier.
 * @property array $names               Available names of a payer.
 * @property array $supported_endpoints Eligible endpoints supported by a payer.
 */
class Payer extends Model implements Resource, Repository
{
    const ELIGIBILITY_CODE = '270';
    const ELIGIBILITY_ENDPOINT = 'coverage';
    const MEDICAL_CLAIMS_CODE = '837P';
    const MEDICAL_CLAIMS_ENDPOINT = 'professional claims';
    const ERA_CODE = '835';
    const ERA_ENDPOINT = 'payment reports';

    public static function eligibleEndpoints()
    {
        return [
            self::ELIGIBILITY_CODE => self::ELIGIBILITY_ENDPOINT,
            self::MEDICAL_CLAIMS_CODE => self::MEDICAL_CLAIMS_ENDPOINT,
            self::ERA_CODE => self::ERA_ENDPOINT,
        ];
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'enrollment_payers_list';

    /**
     * Fields that can be mass assigned
     *
     * @var string[]
     */
    protected $fillable = ['payer_id', 'names', 'supported_endpoints'];

    /**
     * Get enrollment required fields for a payer.
     *
     * @return string[]
     */
    public function requiredFields($endpoint = null)
    {
        $endpoints = collect((array)$this->supported_endpoints);

        if ($endpoint && in_array($endpoint, static::eligibleEndpoints())) {
            $endpoints = $endpoints->filter(function ($supported) use ($endpoint) {
                return $supported['endpoint'] === $endpoint;
            });
        }

        return $endpoints
            ->pluck('enrollment_mandatory_fields')
            ->collapse()
            ->unique()
            ->all();
    }

    /**
     * Accessor for supported_endpoints property
     *
     * @return array|null
     */
    public function getSupportedEndpointsAttribute()
    {
        return json_decode($this->attributes['supported_endpoints'], true);
    }

    /**
     * Mutator for supported_endpoints property
     *
     * @param  string|array $endpoints
     * @return void
     */
    public function setSupportedEndpointsAttribute($endpoints)
    {
        $this->attributes['supported_endpoints'] = json_encode((array)$endpoints);
    }

    /**
     * Accessor for names property
     *
     * @return array|null
     */
    public function getNamesAttribute()
    {
        return json_decode($this->attributes['names'], true);
    }

    /**
     * Mutator for names property
     *
     * @param  string|array $names
     * @return void
     */
    public function setNamesAttribute($names)
    {
        $this->attributes['names'] = json_encode((array)$names);
    }

    /*
    |--------------------------------------------------------------------------
    | Repository implementation
    |--------------------------------------------------------------------------
    */
    public function findByUid($uid)
    {
        return static::query()->where('payer_id', $uid)->first();
    }
}
