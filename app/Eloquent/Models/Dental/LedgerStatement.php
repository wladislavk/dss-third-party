<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Contracts\Repositories\Repository;
use DB;

class LedgerStatement extends AbstractModel implements Resource, Repository
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
