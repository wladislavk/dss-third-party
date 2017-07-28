<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use DentalSleepSolutions\Structs\LetterData;
use Illuminate\Database\Eloquent\Builder;

class LetterRepository extends AbstractRepository
{
    public function model()
    {
        return Letter::class;
    }

    /**
     * @param int $docId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getPending($docId)
    {
        return $this->model->select(\DB::raw('UNIX_TIMESTAMP(dental_letters.generated_date) AS generated_date'))
            ->leftJoin('dental_patients', 'dental_letters.patientid', '=', 'dental_patients.patientid')
            ->where('dental_letters.status', 0)
            ->where('dental_letters.delivered', 0)
            ->where('dental_letters.deleted', 0)
            ->where('dental_letters.docid', $docId)
            ->where(function (Builder $query) {
                return $query->whereNull('dental_letters.parentid')
                    ->orWhere('dental_letters.parentid', 0);
            })
            ->orderBy('generated_date')
            ->get();
    }

    /**
     * @param int $docId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getUnmailed($docId)
    {
        return $this->model->select(\DB::raw('COUNT(letterid) AS total'))
            ->leftJoin('dental_patients', 'dental_letters.patientid', '=', 'dental_patients.patientid')
            ->where(function (Builder $query) {
                return $query->where('dental_letters.status', 1)
                    ->orWhere('dental_letters.delivered', 1);
            })
            ->whereNull('mailed_date')
            ->where('dental_letters.deleted', 0)
            ->where('dental_letters.docid', $docId)
            ->first();
    }

    /**
     * @param int $contactId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getContactSentLetters($contactId)
    {
        return $this->model
            ->where('delivered', 1)
            ->where(function (Builder $query) use ($contactId) {
                $query->whereRaw('FIND_IN_SET(?, md_list)', [$contactId])
                    ->orWhereRaw('FIND_IN_SET(?, md_referral_list)', [$contactId]);
            })->get();
    }

    /**
     * @param int $contactId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getContactPendingLetters($contactId)
    {
        return $this->model
            ->where('delivered', 0)
            ->where(function (Builder $query) use ($contactId) {
                $query->whereRaw('FIND_IN_SET(?, md_list)', [$contactId])
                    ->orWhereRaw('FIND_IN_SET(?, md_referral_list)', [$contactId]);
            })->get();
    }

    /**
     * @param int $docId
     * @param int $templateId
     * @param int $mdList
     */
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

        $this->create($data);
    }

    /**
     * @param int $patientId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getGeneratedDateOfIntroLetter($patientId)
    {
        return $this->model->select('generated_date')
            ->where('templateid', 3)
            ->where('deleted', '0')
            ->where('patientid', $patientId)
            ->orderBy('generated_date')
            ->first();
    }

    /**
     * @param int $patientId
     * @param string $patientReferralIds
     * @return array|\Illuminate\Database\Eloquent\Collection|Letter[]
     */
    public function getPatientTreatmentComplete($patientId, $patientReferralIds)
    {
        return $this->model->select('letterid')
            ->where('patientid', $patientId)
            ->where('templateid', 20)
            ->where('pat_referral_list', $patientReferralIds)
            ->get();
    }

    /**
     * @param int $contactId
     * @param int $letter1Id
     * @param int $letter2Id
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getMdList($contactId, $letter1Id, $letter2Id)
    {
        return $this->model->select('md_list')
            ->whereNotNull('md_list')
            ->whereRaw("CONCAT(',', md_list, ',') LIKE ?", ['%,' . $contactId . ',%'])
            ->whereIn('templateid', [$letter1Id, $letter2Id])
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
        $query = $this->model;

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

    /**
     * @param string $referralList
     * @param int $patientId
     * @param string $type
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getPhysicianOrPatientPendingLetters($referralList, $patientId, $type)
    {
        $field = '';
        switch ($type) {
            case 'physician':
                $field = 'md_referral_list';
                break;
            case 'patient':
                $field = 'pat_referral_list';
                break;
        }

        return $this->model->where($field, $referralList)
            ->where('patientid', $patientId)
            ->where('status', 0)
            ->get();
    }

    /**
     * @param int $oldReferredBy
     * @param int $newReferredBy
     * @param int $patientId
     * @param string $type
     * @return bool|int
     */
    public function updatePendingLettersToNewReferrer($oldReferredBy, $newReferredBy, $patientId, $type)
    {
        $letter = $this->model
            ->where('status', 0)
            ->where('patientid', $patientId);

        $field = '';
        switch ($type) {
            case 'physician':
                $field = 'md_referral_list';
                break;
            case 'patient':
                $field = 'pat_referral_list';
                break;
        }

        return $letter->where($field, $oldReferredBy)
            ->update([
                'template' => null,
                $field     => $newReferredBy,
            ]);
    }

    /**
     * @param LetterData $letterData
     * @return Letter
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
}
