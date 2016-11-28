<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\Letter as Resource;
use DentalSleepSolutions\Contracts\Repositories\Letters as Repository;
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

    public function scopeNonDeleted($query)
    {
        return $query->where('deleted', '0');
    }

    public function scopePatientTreatmentComplete($query)
    {
        return $query->where('templateid', 20);
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

    public function getGeneratedDateOfIntroLetter($patientId = 0)
    {
        return $this->select('generated_date')
            ->where('templateid', 3)
            ->nonDeleted()
            ->where('patientid', $patientId)
            ->orderBy('generated_date')
            ->first();
    }

    public function getPatientTreatmentComplete($patientId = 0, $patientReferralId)
    {
        return $this->select('letterid')
            ->where('patientid', $patientId)
            ->patientTreatmentComplete()
            ->where('pat_referral_list', $patientReferralId)
            ->get();
    }

    public function createLetter($data = [])
    {
        foreach ($data as $value) {
            $value = $value ?: false;
        }

        if (isset($data['parentid']) && $data['status'] != 1) {
            $newLetter['parentid'] = $data['parentid'];
        } else if ($data['status'] == 1) {
            $newLetter['parentid'] = '';
        }

        if (isset($data['topatient']) && !$data['cc_topatient']) {
            $newLetter['cc_topatient'] = $data['topatient'];
        } else {
            $newLetter['cc_topatient'] = $data['cc_topatient'];
        }

        if (isset($data['md_list']) && !$data['cc_md_list']) {
            $newLetter['cc_md_list'] = $data['md_list'];
        } else {
            $newLetter['cc_md_list'] = $data['cc_md_list'];
        }

        if (isset($data['md_referral_list']) && !$data['cc_md_referral_list']) {
            $newLetter['cc_md_referral_list'] = $data['md_referral_list'];
        } else {
            $newLetter['cc_md_referral_list'] = $data['cc_md_referral_list'];
        }

        if (isset($data['pat_referral_list']) && !$data['cc_pat_referral_list']) {
            $newLetter['cc_pat_referral_list'] = $data['pat_referral_list'];
        } else {
            $newLetter['cc_pat_referral_list'] = $data['cc_pat_referral_list'];
        }

        if ($data['template']) {
            $template = html_entity_decode(preg_replace('/(&Acirc;|&acirc;|&nbsp;)+/i', '', $template), ENT_COMPAT | ENT_IGNORE, "UTF-8");
            $newLetter['template'] = $template;
        }

        $newLetter = [
            'templateid'           => $data['templateid'],
            'date_sent'            => $data['status'] == 1 ? Carbon::now() : '',
            'patientid'            => $data['patientid'] > 0 ? $data['patientid'] : 0,
            'info_id'              => $data['info_id'] > 0 ? $data['info_id'] : 0,
            'topatient'            => $data['topatient'],
            'md_list'              => $data['md_list'],
            'cc_md_list'           => $data['cc_md_list'],
            'md_referral_list'     => $data['md_referral_list'],
            'cc_md_referral_list'  => $data['cc_md_referral_list'],
            'pat_referral_list'    => $data['pat_referral_list'],
            'send_method'          => $data['send_method'],
            'status'               => $data['status'],
            'deleted'              => $data['deleted'],
            'deleted_by'           => $data['user_id'],
            'deleted_on'           => Carbon::now(),
            'template_type'        => $data['template_type'],
            'font_size'            => $data['font_size'],
            'font_family'          => $data['font_family'],
            'generated_date'       => Carbon::now(),
            'delivered'            => '0',
            'docid'                => $data['doc_id'],
            'userid'               => $data['user_id']
        ];

        return $this->create($newLetter);
    }
}
