<?php

namespace DentalSleepSolutions\Eloquent\Models\Enrollments;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
