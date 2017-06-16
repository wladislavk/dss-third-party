<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutCreatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\LedgerHistory as Resource;
use DentalSleepSolutions\Contracts\Repositories\LedgerHistories as Repository;
use DB;

class LedgerHistory extends Model implements Resource, Repository
{
    use WithoutCreatedTimestamp;

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
    protected $table = 'dental_ledger_history';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['percase_date'];

    public function getHistoriesForLedgerReport($docId, $patientId, $ledgerId, $type = 'ledger')
    {
        if ($type === 'ledger') {
            $query = $this->select(
                DB::raw("'ledger' as ledger"),
                'dl.ledgerid',
                'dl.service_date',
                'dl.entry_date',
                DB::raw("CONCAT(p.first_name,' ',p.last_name) as name"),
                'dl.description',
                'dl.amount',
                'di.status',
                'dl.primary_claim_id',
                'di.status as claim_status',
                'dl.updated_at',
                DB::raw("CONCAT(u.first_name,' ',u.last_name) as updated_user"),
                DB::raw("CONCAT(a.first_name,' ',a.last_name) as updated_admin")
            )->from(DB::raw('dental_ledger_history dl'))
            ->leftJoin(DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
            ->leftJoin(DB::raw('dental_ledger_payment pay'), 'pay.ledgerid', '=', 'dl.ledgerid')
            ->leftJoin(DB::raw('dental_insurance di'), 'di.insuranceid', '=', 'dl.primary_claim_id')
            ->leftJoin(DB::raw('dental_users u'), 'u.userid', '=', 'dl.updated_by_user')
            ->leftJoin(DB::raw('admin a'), 'a.adminid', '=', 'dl.updated_by_admin')
            ->where('dl.docid', $docId)
            ->where('dl.patientid', $patientId)
            ->whereRaw('coalesce(dl.paid_amount, 0) = ?', 0)
            ->where('dl.ledgerid', $ledgerId)
            ->orderBy('dl.updated_at');
        } else {
            $query = $this->select(
                DB::raw("'ledger_payment' AS ledger"),
                'dlp.id AS ledgerid',
                'dlp.payment_date AS service_date',
                'dlp.entry_date',
                DB::raw("CONCAT(p.first_name, ' ', p.last_name) AS name"),
                DB::raw("'' AS description"),
                'dlp.amount AS paid_amount,',
                DB::raw("'' AS status"),
                DB::raw('IF(
                    dl.secondary_claim_id && dlp.is_secondary,
                    dl.secondary_claim_id,
                    dl.primary_claim_id
                ) AS primary_claim_id'),
                DB::raw("'' AS claim_status"),
                'dl.updated_at',
                DB::raw("CONCAT(u.first_name,' ',u.last_name) as updated_user"),
                DB::raw("CONCAT(a.first_name,' ',a.last_name) as updated_admin")
            )->from(DB::raw('dental_ledger_history dl'))
            ->leftJoin(DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
            ->leftJoin(DB::raw('dental_ledger_payment dlp'), 'dlp.ledgerid', '=', 'dl.ledgerid')
            ->leftJoin(DB::raw('dental_users u'), 'u.userid', '=', 'dl.updated_by_user')
            ->leftJoin(DB::raw('admin a'), 'a.adminid', '=', 'dl.updated_by_admin')
            ->where('dl.docid', $docId)
            ->where('dl.patientid', $patientId)
            ->where('dlp.amount', '!=', 0)
            ->where('dlp.id', $ledgerId);
        }

        return $query->get();
    }
}
