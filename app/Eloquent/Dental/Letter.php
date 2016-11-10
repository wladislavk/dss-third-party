<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\Letter as Resource;
use DentalSleepSolutions\Contracts\Repositories\Letters as Repository;
use Carbon\Carbon;
use DB;

class Letter extends Model implements Resource, Repository
{
    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['letterid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_letters';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'letterid';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'delivery_date', 'date_sent',
        'mailed_date', 'deleted_on'
    ];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'generated_date';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'edit_date';

    public function scopeDelivered($query)
    {
        return $query->where('delivered', 1);
    }

    public function scopeNonDelivered($query)
    {
        return $query->where('delivered', 0);
    }

    public function getPending($docId = 0)
    {
        return $this->select(DB::raw('UNIX_TIMESTAMP(dental_letters.generated_date) AS generated_date'))
            ->leftJoin('dental_patients', 'dental_letters.patientid', '=', 'dental_patients.patientid')
            ->where('dental_letters.status', 0)
            ->where('dental_letters.delivered', 0)
            ->where('dental_letters.deleted', 0)
            ->where('dental_letters.docid', $docId)
            ->where(function($query) {
                return $query->whereNull('dental_letters.parentid')
                    ->orWhere('dental_letters.parentid', 0);
            })
            ->orderBy('generated_date')
            ->get();
    }

    public function getUnmailed($docId = 0)
    {
        return $this->select(DB::raw('COUNT(letterid) AS total'))
            ->leftJoin('dental_patients', 'dental_letters.patientid', '=', 'dental_patients.patientid')
            ->where(function($query) {
                return $query->where('dental_letters.status', 1)
                    ->orWhere('dental_letters.delivered', 1);
            })
            ->whereNull('mailed_date')
            ->where('dental_letters.deleted', 0)
            ->where('dental_letters.docid', $docId)
            ->first();
    }

    public function getContactSentLetters($contactId = 0)
    {
        return $this->delivered()
            ->where(function($query) {
                $query->whereRaw('FIND_IN_SET(?, md_list)', $contactId)
                    ->orWhereRaw('FIND_IN_SET(?, md_referral_list)', $contactId);
            })->get();
    }

    public function getContactPendingLetters($contactId = 0)
    {
        return $this->nonDelivered()
            ->where(function($query) {
                $query->whereRaw('FIND_IN_SET(?, md_list)', $contactId)
                    ->orWhereRaw('FIND_IN_SET(?, md_referral_list)', $contactId);
            })->get();
    }

    public function createWelcomeLetter($docId, $templateId, $mdList)
    {
        $status = '0';
        $delivered = '0';
        $deleted = '0';

        $data = [
            'templateid'     => $templateId,
            'generated_date' => Carbon::now(),
            'delivered'      => $delivered,
            'docid'          => $docId,
            'userid'         => $docId
        ];

        if ($status == 1) {
            $data['date_sent'] = Carbon::now();
        }

        if (isset($md_list)) {
            $data['md_list'] = $mdList;
            $data['cc_md_list'] = $mdList;
        }

        if (isset($status)) {
            $data['status'] = $status;
        }

        if (isset($deleted)) {
            $data['deleted'] = $deleted;
        }

        return $this->create($data);
    }
}
