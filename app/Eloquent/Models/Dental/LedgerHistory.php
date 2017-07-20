<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutCreatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DB;

/**
 * @SWG\Definition(
 *     definition="LedgerHistory",
 *     type="object",
 *     required={"ledgerid", "placeofservice", "emg", "diagnosispointer", "daysorunits", "epsdt", "idqual", "modcode", "id", "secondary_claim_id"},
 *     @SWG\Property(property="ledgerid", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="service_date", type="string"),
 *     @SWG\Property(property="entry_date", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="producer", type="string"),
 *     @SWG\Property(property="amount", type="float"),
 *     @SWG\Property(property="transaction_type", type="string"),
 *     @SWG\Property(property="paid_amount", type="float"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="transaction_code", type="string"),
 *     @SWG\Property(property="placeofservice", type="string"),
 *     @SWG\Property(property="emg", type="string"),
 *     @SWG\Property(property="diagnosispointer", type="string"),
 *     @SWG\Property(property="daysorunits", type="string"),
 *     @SWG\Property(property="epsdt", type="string"),
 *     @SWG\Property(property="idqual", type="string"),
 *     @SWG\Property(property="modcode", type="string"),
 *     @SWG\Property(property="producerid", type="integer"),
 *     @SWG\Property(property="primary_claim_id", type="integer"),
 *     @SWG\Property(property="primary_paper_claim_id", type="string"),
 *     @SWG\Property(property="modcode2", type="string"),
 *     @SWG\Property(property="modcode3", type="string"),
 *     @SWG\Property(property="modcode4", type="string"),
 *     @SWG\Property(property="percase_date", type="string", format="dateTime"),
 *     @SWG\Property(property="percase_name", type="string"),
 *     @SWG\Property(property="percase_amount", type="float"),
 *     @SWG\Property(property="percase_status", type="integer"),
 *     @SWG\Property(property="percase_invoice", type="integer"),
 *     @SWG\Property(property="percase_free", type="integer"),
 *     @SWG\Property(property="updated_by_user", type="integer"),
 *     @SWG\Property(property="updated_by_admin", type="integer"),
 *     @SWG\Property(property="primary_claim_history_id", type="integer"),
 *     @SWG\Property(property="updated_at", type="string", format="dateTime"),
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="secondary_claim_id", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\LedgerHistory
 *
 * @property int $ledgerid
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $service_date
 * @property string|null $entry_date
 * @property string|null $description
 * @property string|null $producer
 * @property float|null $amount
 * @property string|null $transaction_type
 * @property float|null $paid_amount
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property string|null $adddate
 * @property string|null $ip_address
 * @property string|null $transaction_code
 * @property string $placeofservice
 * @property string $emg
 * @property string $diagnosispointer
 * @property string $daysorunits
 * @property string $epsdt
 * @property string $idqual
 * @property string $modcode
 * @property int|null $producerid
 * @property int|null $primary_claim_id
 * @property string|null $primary_paper_claim_id
 * @property string|null $modcode2
 * @property string|null $modcode3
 * @property string|null $modcode4
 * @property \Carbon\Carbon|null $percase_date
 * @property string|null $percase_name
 * @property float|null $percase_amount
 * @property int|null $percase_status
 * @property int|null $percase_invoice
 * @property int|null $percase_free
 * @property int|null $updated_by_user
 * @property int|null $updated_by_admin
 * @property int|null $primary_claim_history_id
 * @property \Carbon\Carbon|null $updated_at
 * @property int $id
 * @property int $secondary_claim_id
 * @mixin \Eloquent
 */
class LedgerHistory extends AbstractModel implements Resource
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
                'dlp.amount AS paid_amount',
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
