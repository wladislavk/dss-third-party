<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

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
 * @mixin \Eloquent
 */
class LedgerNote extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'producerid',
        'note',
        'private',
        'service_date',
        'entry_date',
        'patientid',
        'adddate',
        'ip_address',
        'docid',
        'admin_producerid',
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

    const CREATED_AT = 'adddate';
}
