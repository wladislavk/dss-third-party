<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

class LetterRepository extends AbstractRepository
{
    const REFERRAL_LIST_TYPES = [
        'physician' => 'md_referral_list',
        'patient' => 'pat_referral_list',
    ];

    public function model()
    {
        return Letter::class;
    }

    /**
     * @param int $docId
     * @return array|Collection
     */
    public function getPending($docId)
    {
        return $this->model
            ->select(\DB::raw('UNIX_TIMESTAMP(dental_letters.generated_date) AS generated_date'))
            ->leftJoin('dental_patients', 'dental_letters.patientid', '=', 'dental_patients.patientid')
            ->where('dental_letters.status', 0)
            ->where('dental_letters.delivered', 0)
            ->where('dental_letters.deleted', 0)
            ->where('dental_letters.docid', $docId)
            ->where(function (Builder $query) {
                /** @var Builder|QueryBuilder $builder */
                $builder = $query;
                return $builder
                    ->whereNull('dental_letters.parentid')
                    ->orWhere('dental_letters.parentid', 0)
                ;
            })
            ->orderBy('generated_date')
            ->get()
        ;
    }

    /**
     * @param int $docId
     * @return Model|null
     */
    public function getPendingNumber($docId)
    {
        return $this->model
            ->select(\DB::raw('COUNT(letterid) AS total'))
            ->leftJoin('dental_patients', 'dental_letters.patientid', '=', 'dental_patients.patientid')
            ->where('dental_letters.status', 0)
            ->where('dental_letters.delivered', 0)
            ->where('dental_letters.deleted', 0)
            ->where('dental_letters.docid', $docId)
            ->where(function (Builder $query) {
                /** @var Builder|QueryBuilder $builder */
                $builder = $query;
                return $builder
                    ->whereNull('dental_letters.parentid')
                    ->orWhere('dental_letters.parentid', 0)
                    ;
            })
            ->orderBy('generated_date')
            ->first()
        ;
    }

    /**
     * @param int $docId
     * @return Model|null
     */
    public function getUnmailed($docId)
    {
        return $this->model
            ->select(\DB::raw('COUNT(letterid) AS total'))
            ->leftJoin('dental_patients', 'dental_letters.patientid', '=', 'dental_patients.patientid')
            ->where(function (Builder $query) {
                return $query
                    ->where('dental_letters.status', 1)
                    ->orWhere('dental_letters.delivered', 1)
                ;
            })
            ->whereNull('mailed_date')
            ->where('dental_letters.deleted', 0)
            ->where('dental_letters.docid', $docId)
            ->first()
        ;
    }

    /**
     * @param int $contactId
     * @return array|Collection
     */
    public function getContactSentLetters($contactId)
    {
        return $this->model
            ->where('delivered', 1)
            ->where(function (Builder $query) use ($contactId) {
                /** @var Builder|QueryBuilder $builder */
                $builder = $query;
                $builder
                    ->whereRaw('FIND_IN_SET(?, md_list)', [$contactId])
                    ->orWhereRaw('FIND_IN_SET(?, md_referral_list)', [$contactId])
                ;
            })
            ->get()
        ;
    }

    /**
     * @param int $contactId
     * @return array|Collection
     */
    public function getContactPendingLetters($contactId)
    {
        return $this->model
            ->where('delivered', 0)
            ->where(function (Builder $query) use ($contactId) {
                /** @var Builder|QueryBuilder $builder */
                $builder = $query;
                $builder
                    ->whereRaw('FIND_IN_SET(?, md_list)', [$contactId])
                    ->orWhereRaw('FIND_IN_SET(?, md_referral_list)', [$contactId])
                ;
            })
            ->get()
        ;
    }

    /**
     * @param int $patientId
     * @return Model|null
     */
    public function getGeneratedDateOfIntroLetter($patientId)
    {
        return $this->model
            ->select('generated_date')
            ->where('templateid', 3)
            ->where('deleted', '0')
            ->where('patientid', $patientId)
            ->orderBy('generated_date')
            ->first()
        ;
    }

    /**
     * @param int $patientId
     * @param string $patientReferralIds
     * @return array|Collection
     */
    public function getPatientTreatmentComplete($patientId, $patientReferralIds)
    {
        return $this->model
            ->select('letterid')
            ->where('patientid', $patientId)
            ->where('templateid', 20)
            ->where('pat_referral_list', $patientReferralIds)
            ->get()
        ;
    }

    /**
     * @param int $contactId
     * @param int $letter1Id
     * @param int $letter2Id
     * @return array|Collection
     */
    public function getMdList($contactId, $letter1Id, $letter2Id)
    {
        return $this->model
            ->select('md_list')
            ->whereNotNull('md_list')
            ->whereRaw("CONCAT(',', md_list, ',') LIKE ?", ['%,' . $contactId . ',%'])
            ->whereIn('templateid', [$letter1Id, $letter2Id])
            ->get()
        ;
    }

    /**
     * @return Builder|QueryBuilder
     */
    public function getUpdateLetterBaseQuery()
    {
        return $this->model;
    }

    /**
     * @param Builder $query
     * @param string $column
     * @param string $value
     * @return Builder
     */
    public function getUpdateLetterCondition(Builder $query, $column, $value)
    {
        return $query->where($column, $value);
    }

    /**
     * @param Builder $query
     * @param array $data
     */
    public function doUpdateLetter(Builder $query, array $data)
    {
        $query->update($data);
    }

    /**
     * @param string $referralList
     * @param int $patientId
     * @param string $type
     * @return array|Collection
     */
    public function getPhysicianOrPatientPendingLetters($referralList, $patientId, $type)
    {
        $field = '';
        if (array_key_exists($type, self::REFERRAL_LIST_TYPES)) {
            $field = self::REFERRAL_LIST_TYPES[$type];
        }

        return $this->model
            ->where($field, $referralList)
            ->where('patientid', $patientId)
            ->where('status', 0)
            ->get()
        ;
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
            ->where('patientid', $patientId)
        ;

        $field = '';
        if (array_key_exists($type, self::REFERRAL_LIST_TYPES)) {
            $field = self::REFERRAL_LIST_TYPES[$type];
        }

        return $letter
            ->where($field, $oldReferredBy)
            ->update([
                'template' => null,
                $field     => $newReferredBy,
            ])
        ;
    }

    /**
     * @param int $patientId
     * @param int[] $infoIds
     * @return Letter[]|Collection
     */
    public function getByPatientAndInfo(int $patientId, array $infoIds): iterable
    {
        $result = $this->model
            ->where('patientid', $patientId)
            ->where('deleted', 0)
            ->whereIn('info_id', $infoIds)
            ->orderBy('stepid')
            ->get()
        ;
        return $result;
    }

    /**
     * @param int $patientId
     * @param int[] $letterIdList
     * @return Collection|array
     */
    public function getByPatientAndIdList(int $patientId, array $letterIdList): iterable
    {
        $query = $this->model
            ->select(\DB::raw('COUNT(letterid) AS total, patientid, letterid, UNIX_TIMESTAMP(generated_date) as generated_date, topatient, md_list, md_referral_list, pdf_path, status, delivered, dental_letter_templates.name, dental_letter_templates.template, deleted'))
            ->leftJoin('dental_letter_templates', 'dental_letters.templateid', '=', 'dental_letter_templates.id')
            ->where('patientid', $patientId)
            ->where(function (Builder $query) use ($letterIdList) {
                /** @var Builder|QueryBuilder $builder */
                $builder = $query;
                return $builder
                    ->whereIn('letterid', $letterIdList)
                    ->orWhereIn('parentid', $letterIdList)
                ;
            })
        ;
        return $query->get();
    }
}
