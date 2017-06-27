<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\ContactType as Resource;
use DentalSleepSolutions\Contracts\Repositories\ContactTypes as Repository;
use DB;

/**
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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType active()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType nonCorporate()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType physician()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereContacttype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereContacttypeid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereCorporate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType wherePhysician($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereSortby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereStatus($value)
 * @mixin \Eloquent
 */
class ContactType extends AbstractModel implements Resource, Repository
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
