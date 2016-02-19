<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Ledger as Resource;
use DentalSleepSolutions\Contracts\Repositories\Ledgers as Repository;

class Ledger extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

        /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['ledgerid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ledger';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ledgerid';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['service_date', 'entry_date', 'percase_date'];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    /**
     * Get an attribute array of all arrayable attributes.
     *
     * @return array
     */
    protected function getArrayableAttributes()
    {
        // By default, timestamps are formatted as 'Y-m-d H:i:s'.
        // In our case `adddate` field has `m/d/Y` format.
        // It should be changed to default format in future.

        if (isset($this->attributes[static::CREATED_AT])) {
            $oldFormat = 'm/d/Y';
            $newFormat = 'Y-m-d';

            $this->attributes[static::CREATED_AT] = Carbon::createFromFormat(
                $oldFormat,
                $this->attributes[static::CREATED_AT]
            )->format($newFormat);
        }

        return $this->getArrayableItems($this->attributes);
    }

    /**
     * Set the value of the "created at" attribute.
     *
     * @param  mixed  $value
     * @return $this
     */
    public function setCreatedAt($value)
    {
        $this->{static::CREATED_AT} = $value->format('m/d/Y');

        return $this;
    }

    /**
     * Set mutator of the "created at" attribute.
     *
     * @param  mixed  $value
     * @return $this
     */
    public function setAdddateAttribute($value)
    {
        $this->attributes[static::CREATED_AT] = $value;
    }

    public static function getForSendClaim($pid, $insid, $docid, $type)
    {
        return self::select('dental_ledger.*')
            ->join('dental_users', 'dental_users.userid', '=', 'dental_ledger.docid')
            ->join('dental_transaction_code', 'dental_transaction_code.transaction_code', '=', 'dental_ledger.transaction_code')
            ->leftJoin('dental_place_service', 'dental_transaction_code.place', '=', 'dental_place_service.place_serviceid')
            ->where('dental_ledger.primary_claim_id', $insid)
            ->where('dental_ledger.patientid', $pid)
            ->where('dental_ledger.docid', $docid)
            ->where('dental_transaction_code.docid', $docid)
            ->where('dental_transaction_code.type', $type)
            ->orderBy('dental_ledger.service_date', 'ASC')
            ->get();
    }
}
