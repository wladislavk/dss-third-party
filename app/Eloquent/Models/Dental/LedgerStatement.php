<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DB;

/**
 * @SWG\Definition(
 *     definition="LedgerStatement",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="producerid", type="integer"),
 *     @SWG\Property(property="filename", type="string"),
 *     @SWG\Property(property="service_date", type="string"),
 *     @SWG\Property(property="entry_date", type="string"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\LedgerStatement
 *
 * @property int $id
 * @property int|null $producerid
 * @property string|null $filename
 * @property string|null $service_date
 * @property string|null $entry_date
 * @property int|null $patientid
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @mixin \Eloquent
 */
class LedgerStatement extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'producerid', 'filename', 'service_date', 'entry_date',
        'patientid', 'adddate', 'ip_address'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ledger_statement';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function getLedgerDetailsQuery($docId, $patientId)
    {
        return $this->select(
            's.patientid',
            DB::raw("'$docId'"),
            DB::raw("'statement'"),
            's.id',
            's.service_date',
            's.entry_date',
            DB::raw("CONCAT(p.first_name, ' ', p.last_name)"),
            DB::raw("'Ledger statement created (Click to view)'"),
            DB::raw('0.0'),
            DB::raw('0.0'),
            DB::raw("''"),
            DB::raw('0'),
            DB::raw('NULL'),
            DB::raw("''"),
            DB::raw("''"),
            DB::raw("''"),
            's.filename',
            DB::raw("''"),
            DB::raw("''"),
            DB::raw('0 AS filed_by_bo')
        )->from(DB::raw('dental_ledger_statement s'))
        ->join(DB::raw('dental_users p'), 's.producerid', '=', 'p.userid')
        ->where('s.patientid', $patientId);
    }

    public function getLedgerDetailsRowsNumber($patientId)
    {
        $query = $this->select(
                DB::raw('COUNT(s.id) as number')
            )->from(DB::raw('dental_ledger_statement s'))
            ->join(DB::raw('dental_users p'), 's.producerid', '=', 'p.userid')
            ->where('s.patientid', $patientId)
            ->first();

        return !empty($query) ? $query->number : 0;
    }

    public function removeByIdAndPatientId($id, $patientId)
    {
        return $this->where('id', $id)
            ->where('patientid', $patientId)
            ->delete();
    }
}
