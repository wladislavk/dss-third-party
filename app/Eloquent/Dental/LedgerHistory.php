<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutCreatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\LedgerHistory as Resource;
use DentalSleepSolutions\Contracts\Repositories\LedgerHistories as Repository;
use DB;

/**
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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereDaysorunits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereDiagnosispointer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereEmg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereEntryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereEpsdt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereIdqual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereLedgerid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereModcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereModcode2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereModcode3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereModcode4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePercaseAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePercaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePercaseFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePercaseInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePercaseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePercaseStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePlaceofservice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePrimaryClaimHistoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePrimaryClaimId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePrimaryPaperClaimId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereProducer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereProducerid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereSecondaryClaimId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereServiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereTransactionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereTransactionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereUpdatedByAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereUpdatedByUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereUserid($value)
 * @mixin \Eloquent
 */
class LedgerHistory extends AbstractModel implements Resource, Repository
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
