<?php

namespace DentalSleepSolutions\Eloquent\Enrollments;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *     definition="Enrollment",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="user_id", type="integer"),
 *     @SWG\Property(property="payer_id", type="string"),
 *     @SWG\Property(property="reference_id", type="integer"),
 *     @SWG\Property(property="response", type="string"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="payer_name", type="string"),
 *     @SWG\Property(property="transaction_type_id", type="integer"),
 *     @SWG\Property(property="enrollment_invoice_id", type="integer"),
 *     @SWG\Property(property="npi", type="string"),
 *     @SWG\Property(property="facility_name", type="string"),
 *     @SWG\Property(property="provider_name", type="string"),
 *     @SWG\Property(property="tax_id", type="string"),
 *     @SWG\Property(property="address", type="string"),
 *     @SWG\Property(property="city", type="string"),
 *     @SWG\Property(property="state", type="string"),
 *     @SWG\Property(property="zip", type="string"),
 *     @SWG\Property(property="first_name", type="string"),
 *     @SWG\Property(property="last_name", type="string"),
 *     @SWG\Property(property="contact_number", type="string"),
 *     @SWG\Property(property="email", type="string"),
 *     @SWG\Property(property="download_url", type="string"),
 *     @SWG\Property(property="signed_download_url", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Enrollments\Enrollment
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $payer_id
 * @property int|null $reference_id
 * @property string|null $response
 * @property int|null $status
 * @property string|null $adddate
 * @property string|null $ip_address
 * @property string|null $payer_name
 * @property int|null $transaction_type_id
 * @property int|null $enrollment_invoice_id
 * @property string|null $npi
 * @property string|null $facility_name
 * @property string|null $provider_name
 * @property string|null $tax_id
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $contact_number
 * @property string|null $email
 * @property string|null $download_url
 * @property string|null $signed_download_url
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereDownloadUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereEnrollmentInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereFacilityName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereNpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment wherePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment wherePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereProviderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereSignedDownloadUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereTransactionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereZip($value)
 * @mixin \Eloquent
 */
class Enrollment extends Model
{
    const DSS_ENROLLMENT_SUBMITTED    = 0;
    const DSS_ENROLLMENT_ACCEPTED     = 1;
    const DSS_ENROLLMENT_REJECTED     = 2;
    const DSS_ENROLLMENT_PDF_RECEIVED = 3;
    const DSS_ENROLLMENT_PDF_SENT     = 4;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'payer_id', 'payer_name', 'npi', 'reference_id', 'response',
        'transaction_type_id', 'status', 'facility_name', 'provider_name',
        'tax_id', 'address', 'city', 'state', 'zip', 'first_name',
        'last_name', 'contact_number', 'email', 'adddate', 'ip_address',
        'enrollment_invoice_id', 'download_url', 'signed_download_url',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_eligible_enrollment';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * create new enrollment
     *
     * @param  array   $inputs
     * @param  integer $user_id
     * @param  string  $payer_id
     * @param  string  $payer_name
     * @param  integer $ref_id
     * @param  string  $result
     * @param  string  $ip
     * @return integer|string
     */
    public static function add($inputs, $user_id, $payer_id, $payer_name, $ref_id, $result, $ip)
    {
        $enrollment = new static;
        $enrollment->user_id = $user_id;
        $enrollment->payer_id = $payer_id;
        $enrollment->payer_name = $payer_name;
        $enrollment->npi = $inputs['npi'];
        $enrollment->reference_id = $ref_id;
        $enrollment->response = $result;
        $enrollment->transaction_type_id = $inputs['transaction_type_id'];
        $enrollment->status = 0;
        $enrollment->facility_name = $inputs['facility_name'];
        $enrollment->provider_name = $inputs['provider_name'];
        $enrollment->tax_id = $inputs['tax_id'];
        $enrollment->address = $inputs['address'];
        $enrollment->city = $inputs['city'];
        $enrollment->state = $inputs['state'];
        $enrollment->zip = $inputs['zip'];
        $enrollment->first_name = $inputs['first_name'];
        $enrollment->last_name = $inputs['last_name'];
        $enrollment->contact_number = $inputs['contact_number'];
        $enrollment->email = $inputs['email'];
        $enrollment->adddate = Carbon::now();
        $enrollment->ip_address = $ip;
        $enrollment->save();

        return $enrollment->id;
    }

    /**
     * @param bool $userId
     * @param bool $pagination
     * @param bool $search
     * @param string $sort
     * @param string $sort_type
     * @return mixed
     */
    public static function getList(
        $userId = false,
        $pagination = false,
        $search = false,
        $sort = 'transaction_type',
        $sort_type = 'asc'
    ) {
        $query = self::select([
            "dental_eligible_enrollment.*",
            \DB::raw("CONCAT(types.transaction_type,' - ',types.description) as transaction_type")
            ])
            ->join('dental_enrollment_transaction_type as types', function ($q) {
                $q->on('dental_eligible_enrollment.transaction_type_id', '=', 'types.id');
            })
            ->orderBy($sort, $sort_type);

        if ($userId !== false) {
            $query->where(\DB::raw('dental_eligible_enrollment.user_id'), '=', $userId);
        }

        if ($search && $search != '') {
            $query->where(function ($q) use ($search) {
                $q->where('dental_eligible_enrollment.provider_name', 'like', "%$search%")
                ->orWhere('types.transaction_type', 'like', "%$search%")
                ->orWhere('types.description', 'like', "%$search%")
                ->orWhere('dental_eligible_enrollment.npi', 'like', "%$search%")
                ->orWhere('dental_eligible_enrollment.payer_id', 'like', "%$search%")
                ->orWhere('dental_eligible_enrollment.payer_name', 'like', "%$search%")
                ->orWhere('dental_eligible_enrollment.adddate', 'adddate', "%$search%");
            });
        }

        if ($pagination) {
            return $query->paginate($pagination);
        }

        return $query->get();
    }


    /**
     * @param  integer $reference_id
     * @param  integer $status
     * @return boolean
     */
    public static function setStatus($reference_id, $status)
    {
        return self::where('reference_id', $reference_id)
            ->update(['status' => $status]);
    }

    /**
     * @param  integer $reference_id
     * @param  string $download_url
     * @return boolean
     */
    public static function setDownloadUrl($reference_id, $download_url)
    {
        return self::where('reference_id', $reference_id)
            ->update(['download_url' => $download_url]);
    }

    /**
     * @param  integer $reference_id
     * @param  string $signed_download_url
     * @return boolean
     */
    public static function setSignedDownloadUrl($reference_id, $signed_download_url)
    {
        return self::where('reference_id', $reference_id)
            ->update(['signed_download_url' => $signed_download_url]);
    }

    /**
     * Get enrollment by reference id.
     *
     * @param  integer $reference_id
     * @return static|null
     */
    public static function getWhereReference($reference_id)
    {
        return self::where('reference_id', $reference_id)->first();
    }
}
