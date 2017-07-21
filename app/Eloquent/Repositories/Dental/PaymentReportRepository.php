<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PaymentReport;
use Prettus\Repository\Eloquent\BaseRepository;

class PaymentReportRepository extends BaseRepository
{
    public function model()
    {
        return PaymentReport::class;
    }

    /**
     * @param int $docId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getNumber($docId)
    {
        return $this->model->select(\DB::raw('COUNT(payment_id) AS total'))
            ->from(\DB::raw('dental_payment_reports AS pr'))
            ->join(\DB::raw('dental_insurance AS i'), 'i.insuranceid', '=', 'pr.claimid')
            ->where('i.docid', $docId)
            ->whereRaw('COALESCE(pr.viewed, 0) != 1')
            ->first();
    }
}
