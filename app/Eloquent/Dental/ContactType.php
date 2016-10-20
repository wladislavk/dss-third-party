<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\ContactType as Resource;
use DentalSleepSolutions\Contracts\Repositories\ContactTypes as Repository;
use DB;

class ContactType extends Model implements Resource, Repository
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
}
