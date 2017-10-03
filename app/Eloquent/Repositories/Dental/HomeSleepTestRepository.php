<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\EpworthHomeSleepTest;
use DentalSleepSolutions\Eloquent\Models\Dental\HomeSleepTest;
use DentalSleepSolutions\Eloquent\Models\Dental\ScreenerEpworth;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;

class HomeSleepTestRepository extends AbstractRepository
{
    public function model()
    {
        return HomeSleepTest::class;
    }

    /**
     * @param int $patientId
     * @return mixed
     */
    public function getUncompleted($patientId)
    {
        return $this->model
            ->where(function (Builder $query) {
                $query
                    ->where('status', HomeSleepTest::DSS_HST_REQUESTED)
                    ->orWhere('status', HomeSleepTest::DSS_HST_PENDING)
                    ->orWhere('status', HomeSleepTest::DSS_HST_SCHEDULED)
                    ->orWhere(function (Builder $query) {
                        $query
                            ->where('status', HomeSleepTest::DSS_HST_REJECTED)
                            ->where(function (Builder $query) {
                                $query
                                    ->whereNull('viewed')
                                    ->orWhere('viewed', 0)
                                ;
                            });
                    })
                ;
            })
            ->where('patient_id', $patientId)
            ->get()
        ;
    }

    /**
     * @param int $docId
     * @return mixed
     */
    public function getCompleted($docId)
    {
        return $this->model
            ->select(\DB::raw('COUNT(id) AS total'))
            ->where('doc_id', $docId)
            ->whereRaw('COALESCE(viewed, 0) != 1')
            ->where('status', HomeSleepTest::DSS_HST_COMPLETE)
            ->first()
        ;
    }

    /**
     * @param int $docId
     * @return mixed
     */
    public function getRequested($docId)
    {
        return $this->model
            ->select(\DB::raw('COUNT(id) AS total'))
            ->where('doc_id', $docId)
            ->whereRaw('COALESCE(viewed, 0) != 1')
            ->where('status', HomeSleepTest::DSS_HST_REQUESTED)
            ->first()
        ;
    }

    /**
     * @param int $docId
     * @return mixed
     */
    public function getRejected($docId)
    {
        return $this->model
            ->select(\DB::raw('COUNT(id) AS total'))
            ->where('doc_id', $docId)
            ->whereRaw('COALESCE(viewed, 0) != 1')
            ->where('status', HomeSleepTest::DSS_HST_REJECTED)
            ->first()
        ;
    }

    /**
     * @param array $data
     * @param array[] $epworthData
     * @return HomeSleepTest
     */
    public function createWithEpworth(array $data, array $epworthData)
    {
        $data['status'] = HomeSleepTest::DSS_HST_REQUESTED;
        /** @var HomeSleepTest $hst */
        $hst = $this->create($data);
        foreach ($epworthData as $epworthElement) {
            $epworthRecord = new EpworthHomeSleepTest();
            $epworthRecord->hst_id = $hst->id;
            $epworthRecord->epworth_id = $epworthElement['epworth_id'];
            $epworthRecord->response = $epworthElement['response'];
            $epworthRecord->adddate = $hst->adddate;
            $epworthRecord->ip_address = $hst->ip_address;
            $epworthRecord->save();
        }
        return $hst;
    }
}
