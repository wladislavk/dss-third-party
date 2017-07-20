<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DB;

/**
 * @SWG\Definition(
 *     definition="ContactType",
 *     type="object",
 *     required={"contacttypeid", "ip_address"},
 *     @SWG\Property(property="contacttypeid", type="integer"),
 *     @SWG\Property(property="contacttype", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="physician", type="integer"),
 *     @SWG\Property(property="corporate", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\ContactType
 *
 * @property int $contacttypeid
 * @property string|null $contacttype
 * @property string|null $description
 * @property int|null $sortby
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string $ip_address
 * @property int|null $physician
 * @property int|null $corporate
 * @mixin \Eloquent
 */
class ContactType extends AbstractModel implements Resource
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'contacttype', 'description', 'sortby', 'status',
        'adddate', 'ip_address', 'physician', 'corporate'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_contacttype';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'contacttypeid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeNonCorporate($query)
    {
        return $query->where('corporate', 0);
    }

    public function scopePhysician($query)
    {
        return $query->where('physician', 1);
    }

    public function getActiveNonCorporateTypes()
    {
        return $this->select('contacttypeid', 'contacttype')
            ->active()
            ->nonCorporate()
            ->orderBy('sortby')
            ->get();
    }

    public function getPhysicianTypes()
    {
        return $this->select(DB::raw('GROUP_CONCAT(contacttypeid) as physician_types'))
            ->physician()
            ->groupBy('physician')
            ->first();
    }

    public function getWithFilter($fields = [], $where = [])
    {
        $object = $this;

        if (count($fields)) {
            $object = $object->select($fields);
        }

        if (count($where)) {
            foreach ($where as $key => $value) {
                $object = $object->where($key, $value);
            }
        }

        return $object->get();
    }

    public function getSorted()
    {
        return $this->orderBy('sortby')
            ->get();
    }
}
