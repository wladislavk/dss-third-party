<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="Ledger",
 *     type="object",
 *     required={"ledgerid", "placeofservice", "emg", "diagnosispointer", "daysorunits", "epsdt", "idqual", "modcode"},
 *     @SWG\Property(property="ledgerid", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="service_date", type="string", format="dateTime"),
 *     @SWG\Property(property="entry_date", type="string", format="dateTime"),
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
 *     @SWG\Property(property="secondary_claim_id", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Ledger
 *
 * @property int $ledgerid
 * @property int|null $formid
 * @property int|null $patientid
 * @property \Carbon\Carbon|null $service_date
 * @property \Carbon\Carbon|null $entry_date
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
 * @property int|null $secondary_claim_id
 * @mixin \Eloquent
 */
class Ledger extends AbstractModel
{
    const DSS_TRXN_TYPE_ADJ = 6;

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
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
