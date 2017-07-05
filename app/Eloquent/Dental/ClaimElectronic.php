<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="ClaimElectronic",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="claimid", type="integer"),
 *     @SWG\Property(property="response", type="string"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="reference", type="string"),
 *     @SWG\Property(property="percase", type="string"),
 *     @SWG\Property(property="percase", type="string"),
 *     @SWG\Property(property="percase", type="float"),
 *     @SWG\Property(property="percase", type="integer"),
 *     @SWG\Property(property="percase", type="integer"),
 *     @SWG\Property(property="percase", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\ClaimElectronic
 *
 * @property int $id
 * @property int|null $claimid
 * @property string|null $response
 * @property string|null $adddate
 * @property string|null $ip_address
 * @property string|null $reference_id
 * @property string|null $percase_date
 * @property string|null $percase_name
 * @property float|null $percase_amount
 * @property int|null $percase_status
 * @property int|null $percase_invoice
 * @property int|null $percase_free
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic whereClaimid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic wherePercaseAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic wherePercaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic wherePercaseFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic wherePercaseInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic wherePercaseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic wherePercaseStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic whereResponse($value)
 * @mixin \Eloquent
 */
/**
 * @SWG\Definition(
 *     definition="ClaimElectronic",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="claimid", type="integer"),
 *     @SWG\Property(property="response", type="string"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="reference", type="string"),
 *     @SWG\Property(property="percase", type="string"),
 *     @SWG\Property(property="percase", type="string"),
 *     @SWG\Property(property="percase", type="float"),
 *     @SWG\Property(property="percase", type="integer"),
 *     @SWG\Property(property="percase", type="integer"),
 *     @SWG\Property(property="percase", type="integer")
 * )
 */
class ClaimElectronic extends AbstractModel
{
    protected $table = 'dental_claim_electronic';
    public $timestamps = false;
}
