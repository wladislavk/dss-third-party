<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Enrollments;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Enrollments\Enrollment;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Database\Query\Builder;

class EnrollmentRepository extends AbstractRepository
{
    public function model()
    {
        return Enrollment::class;
    }

    /**
     * @param array $inputs
     * @param int $userId
     * @param string $payerId
     * @param string $payerName
     * @param int $refId
     * @param string $result
     * @param string $ip
     * @return int
     */
    public function add($inputs, $userId, $payerId, $payerName, $refId, $result, $ip)
    {
        $enrollment = new Enrollment();
        $enrollment->user_id = $userId;
        $enrollment->payer_id = $payerId;
        $enrollment->payer_name = $payerName;
        $enrollment->npi = $inputs['npi'];
        $enrollment->reference_id = $refId;
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
     * @param int $userId
     * @param bool $pagination
     * @param bool $search
     * @param string $sort
     * @param string $sortType
     * @return mixed
     */
    public function getList($userId, $pagination, $search, $sort, $sortType)
    {
        $query = $this->model->select([
            "dental_eligible_enrollment.*",
            \DB::raw("CONCAT(types.transaction_type,' - ',types.description) as transaction_type")
        ])
            ->join('dental_enrollment_transaction_type as types', function ($q) {
                $q->on('dental_eligible_enrollment.transaction_type_id', '=', 'types.id');
            })
            ->orderBy($sort, $sortType);

        $query->where(\DB::raw('dental_eligible_enrollment.user_id'), '=', $userId);

        if ($search && $search != '') {
            $query->where(function (Builder $q) use ($search) {
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
     * @param int $referenceId
     * @param int $status
     * @return bool
     */
    public function setStatus($referenceId, $status)
    {
        return $this->model->where('reference_id', $referenceId)
            ->update(['status' => $status]);
    }

    /**
     * @param int $referenceId
     * @param string $downloadUrl
     * @return bool
     */
    public function setDownloadUrl($referenceId, $downloadUrl)
    {
        return $this->model->where('reference_id', $referenceId)
            ->update(['download_url' => $downloadUrl]);
    }

    /**
     * @param int $referenceId
     * @param string $signedDownloadUrl
     * @return bool
     */
    public function setSignedDownloadUrl($referenceId, $signedDownloadUrl)
    {
        return $this->model->where('reference_id', $referenceId)
            ->update(['signed_download_url' => $signedDownloadUrl]);
    }

    /**
     * @param int $referenceId
     * @return Enrollment|null
     */
    public function getWhereReference($referenceId)
    {
        return $this->model->where('reference_id', $referenceId)->first();
    }
}
