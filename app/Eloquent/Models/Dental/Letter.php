<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Structs\LetterData;
use DentalSleepSolutions\Contracts\Resources\Letter as Resource;
use DentalSleepSolutions\Contracts\Repositories\Letters as Repository;
use Carbon\Carbon;
use DB;

class Letter extends AbstractModel implements Resource, Repository
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
  
    public function scopeNonDeleted($query)
    {
        return $query->where('deleted', '0');
    }

    public function scopePatientTreatmentComplete($query)
    {
        return $query->where('templateid', 20);
    }

    public function scopePending($query)
    {
        return $query->where('status', 0);
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
  
    public function getGeneratedDateOfIntroLetter($patientId = 0)
    {
        return $this->select('generated_date')
            ->where('templateid', 3)
            ->nonDeleted()
            ->where('patientid', $patientId)
            ->orderBy('generated_date')
            ->first();
    }

    /**
     * @param int $patientId
     * @param string $patientReferralIds
     * @return array|\Illuminate\Database\Eloquent\Collection|Letter[]
     */
    public function getPatientTreatmentComplete($patientId = 0, $patientReferralIds = '')
    {
        return $this->select('letterid')
            ->where('patientid', $patientId)
            ->patientTreatmentComplete()
            ->where('pat_referral_list', $patientReferralIds)
            ->get();
    }

    /**
     * @param LetterData $letterData
     * @return static
     */
    public function createLetter(LetterData $letterData)
    {
        if (isset($letterData->parentId) && $letterData->status != true) {
            $newLetter['parentid'] = $letterData->parentId;
        } elseif ($letterData->status == true) {
            $newLetter['parentid'] = '';
        }

        if ($letterData->toPatient !== null && !$letterData->ccToPatient) {
            $newLetter['cc_topatient'] = $letterData->toPatient;
        } else {
            $newLetter['cc_topatient'] = $letterData->ccToPatient;
        }

        if ($letterData->mdList !== null && !$letterData->ccMdList) {
            $newLetter['cc_md_list'] = $letterData->mdList;
        } else {
            $newLetter['cc_md_list'] = $letterData->ccMdList;
        }

        if ($letterData->mdReferralList !== null && !$letterData->ccMdReferralList) {
            $newLetter['cc_md_referral_list'] = $letterData->mdReferralList;
        } else {
            $newLetter['cc_md_referral_list'] = $letterData->ccMdReferralList;
        }

        if ($letterData->patientReferralList !== null && !$letterData->ccPatientReferralList) {
            $newLetter['cc_pat_referral_list'] = $letterData->patientReferralList;
        } else {
            $newLetter['cc_pat_referral_list'] = $letterData->ccPatientReferralList;
        }

        if ($letterData->template) {
            $regExp = '/(&Acirc;|&acirc;|&nbsp;)+/i';
            $template = html_entity_decode(
                preg_replace($regExp, '', $letterData->template),
                ENT_COMPAT | ENT_IGNORE,
                "UTF-8"
            );
            $newLetter['template'] = $template;
        }

        $dateSent = '';
        if ($letterData->status == true) {
            $dateSent = Carbon::now();
        }
        $patientId = 0;
        if ($letterData->patientId > 0) {
            $patientId = $letterData->patientId;
        }
        $infoId = 0;
        if ($letterData->infoId > 0) {
            $infoId = $letterData->infoId;
        }
        $newLetter = [
            'templateid'           => $letterData->templateId,
            'date_sent'            => $dateSent,
            'patientid'            => $patientId,
            'info_id'              => $infoId,
            'topatient'            => $letterData->toPatient,
            'md_list'              => $letterData->mdList,
            'cc_md_list'           => $letterData->ccMdList,
            'md_referral_list'     => $letterData->mdReferralList,
            'cc_md_referral_list'  => $letterData->ccMdReferralList,
            'pat_referral_list'    => $letterData->patientReferralList,
            'send_method'          => $letterData->sendMethod,
            'status'               => $letterData->status,
            'deleted'              => $letterData->deleted,
            'deleted_by'           => $letterData->userId,
            'deleted_on'           => Carbon::now(),
            'template_type'        => $letterData->templateType,
            'font_size'            => $letterData->fontSize,
            'font_family'          => $letterData->fontFamily,
            'generated_date'       => Carbon::now(),
            'delivered'            => '0',
            'docid'                => $letterData->docId,
            'userid'               => $letterData->userId,
        ];

        return $this->create($newLetter);
    }

    public function getMdList($contactId, $letter1Id = 0, $letter2Id = 0)
    {
        return $this->select('md_list')
            ->whereNotNull('md_list')
            ->whereRaw("CONCAT(',', md_list, ',') LIKE ?", ['%,' . $contactId . ',%'])
            ->whereIn('templateid', [$letter1Id, $letter2Id])
            ->get();
    }

    public function updatePendingLettersToNewReferrer($oldReferredBy, $newReferredBy, $patientId, $type)
    {
        $letter = $this->pending()
            ->where('patientid', $patientId);

        switch ($type) {
            case 'physician':
                $field = 'md_referral_list';
                break;

            case 'patient':
                $field = 'pat_referral_list';
                break;

            default:
                break;
        }

        return $letter->where($field, $oldReferredBy)
            ->update([
                'template' => null,
                $field     => $newReferredBy
            ]);
    }

    public function getPhysicianOrPatientPendingLetters($referralList, $patientId, $type = 'physician')
    {
        switch ($type) {
            case 'physician':
                $field = 'md_referral_list';
                break;

            case 'patient':
                $field = 'pat_referral_list';
                break;

            default:
                $field = '';
                break;
        }

        return $this->where($field, $referralList)
            ->where('patientid', $patientId)
            ->pending()
            ->get();
    }

    /**
     * @param array $where
     * @param LetterData $data
     * @param array $fields
     * @return bool|int
     */
    public function updateLetterBy(array $where, LetterData $data, array $fields)
    {
        $query = $this;

        foreach ($where as $key => $value) {
            $query = $query->where($key, $value);
        }

        $dataArray = $data->toArray();
        $updated = [];
        foreach ($fields as $field) {
            if (isset($dataArray[$field])) {
                $updated[$field] = $dataArray[$field];
            }
        }
        return $query->update($updated);
    }
}
