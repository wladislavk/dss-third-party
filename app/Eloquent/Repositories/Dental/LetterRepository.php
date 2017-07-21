<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use Prettus\Repository\Eloquent\BaseRepository;

class LetterRepository extends BaseRepository
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
            ->where(function($query) {
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
            ->where(function($query) {
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
        return $this->model->delivered()
            ->where(function($query) use ($contactId) {
                $query->whereRaw('FIND_IN_SET(?, md_list)', $contactId)
                    ->orWhereRaw('FIND_IN_SET(?, md_referral_list)', $contactId);
            })->get();
    }

    /**
     * @param int $contactId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getContactPendingLetters($contactId)
    {
        return $this->model->nonDelivered()
            ->where(function($query) use ($contactId) {
                $query->whereRaw('FIND_IN_SET(?, md_list)', $contactId)
                    ->orWhereRaw('FIND_IN_SET(?, md_referral_list)', $contactId);
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
            ->nonDeleted()
            ->where('patientid', $patientId)
            ->orderBy('generated_date')
            ->first();
    }
}
