<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\LedgerNote as Resource;
use DentalSleepSolutions\Contracts\Repositories\LedgerNotes as Repository;
use DB;

/**
 * @SWG\Definition(
 *     definition="LedgerNote",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="producerid", type="integer"),
 *     @SWG\Property(property="note", type="string"),
 *     @SWG\Property(property="private", type="integer"),
 *     @SWG\Property(property="service_date", type="string", format="dateTime"),
 *     @SWG\Property(property="entry_date", type="string", format="dateTime"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="admin_producerid", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\LedgerNote
 *
 * @property int $id
 * @property int|null $producerid
 * @property string|null $note
 * @property int|null $private
 * @property \Carbon\Carbon|null $service_date
 * @property \Carbon\Carbon|null $entry_date
 * @property int|null $patientid
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $docid
 * @property int|null $admin_producerid
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereAdminProducerid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereEntryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote wherePrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereProducerid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereServiceDate($value)
 * @mixin \Eloquent
 */
class LedgerNote extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'producerid', 'note', 'private', 'service_date',
        'entry_date', 'patientid', 'adddate', 'ip_address',
        'docid', 'admin_producerid'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ledger_note';

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
    protected $dates = ['service_date', 'entry_date'];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function getLedgerDetailsQuery($patientId)
    {
        $userQuery = $this->select(
            'n.patientid',
            'n.docid',
            DB::raw("'note' AS ledger"),
            'n.id AS ledgerid',
            'n.service_date',
            'n.entry_date',
            DB::raw("CONCAT('Note - ', p.first_name, ' ', p.last_name) AS name"),
            'n.note AS description',
            DB::raw('0.0 AS amount'),
            DB::raw('0.0 AS paid_amount'),
            'n.private AS status',
            DB::raw('0 AS primary_claim_id'),
            DB::raw('NULL AS mailed_date'),
            DB::raw("'' AS payer"),
            DB::raw("'' AS payment_type"),
            DB::raw("'' AS claim_status"),
            DB::raw("'' AS filename"),
            DB::raw("'' AS num_notes"),
            DB::raw("'' AS num_fo_notes"),
            DB::raw("0 AS filed_by_bo")
        )->from(DB::raw('dental_ledger_note n'))
        ->join(DB::raw('dental_users p'), 'n.producerid', '=', 'p.userid')
        ->where('n.patientid', $patientId);

        $adminQuery = $this->select(
            'n.patientid',
            'n.docid',
            DB::raw("'note'"),
            'n.id',
            'n.service_date',
            'n.entry_date',
            DB::raw("CONCAT('Note - Backoffice ID - ', p.adminid)"),
            'n.note',
            DB::raw('0.0'),
            DB::raw('0.0'),
            'n.private',
            DB::raw('0'),
            DB::raw('NULL'),
            DB::raw("''"),
            DB::raw("''"),
            DB::raw("''"),
            DB::raw("''"),
            DB::raw("''"),
            DB::raw("''"),
            DB::raw("0 AS filed_by_bo")
        )->from(DB::raw('dental_ledger_note n'))
        ->join(DB::raw('admin p'), 'n.admin_producerid', '=', 'p.adminid')
        ->where('n.patientid', $patientId);

        return [
            'users'  => $userQuery,
            'admins' => $adminQuery
        ];
    }

    public function getLedgerDetailsRowsNumber($patientId)
    {
        $userQuery = $this->select(
                DB::raw('COUNT(n.id) as number')
            )->from(DB::raw('dental_ledger_note n'))
            ->join(DB::raw('dental_users p'), 'n.producerid', '=', 'p.userid')
            ->where('n.patientid', $patientId)
            ->first();

        $adminQuery = $this->select(
                DB::raw('COUNT(n.id) as number')
            )->from(DB::raw('dental_ledger_note n'))
            ->join(DB::raw('admin p'), 'n.admin_producerid', '=', 'p.adminid')
            ->where('n.patientid', $patientId)
            ->first();

        return (!empty($userQuery) ? $userQuery->number : 0)
            + (!empty($adminQuery) ? $adminQuery->number : 0);
    }
}
