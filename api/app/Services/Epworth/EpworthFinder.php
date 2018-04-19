<?php

namespace DentalSleepSolutions\Services\Epworth;

use DentalSleepSolutions\Eloquent\Repositories\Dental\EpworthSleepinessScaleRepository;
use DentalSleepSolutions\Http\Requests\EpworthSleepinessScale;
use Illuminate\Database\Eloquent\Collection;

class EpworthFinder
{
    /** @var EpworthSleepinessScaleRepository */
    private $epworthRepository;

    public function __construct(EpworthSleepinessScaleRepository $epworthSleepinessScaleRepository)
    {
        $this->epworthRepository = $epworthSleepinessScaleRepository;
    }

    /**
     * @param string $status
     * @param string $order
     * @return EpworthSleepinessScale[]|Collection
     */
    public function findEpworth($status, $order)
    {
        if ($order) {
            $this->epworthRepository->orderBy($order);
        }
        $conditions = [];
        if ($status) {
            $conditions['status'] = $status;
        }
        return $this->epworthRepository->findWhere($conditions);
    }
}
