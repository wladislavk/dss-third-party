<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Sleeplab;
use Prettus\Repository\Eloquent\BaseRepository;

class SleeplabRepository extends BaseRepository
{
    public function model()
    {
        return Sleeplab::class;
    }

    /**
     * @param int $docId
     * @param int $page
     * @param int $rowsPerPage
     * @param string|null $sort
     * @param string $sortDir
     * @param string $letter
     * @return array
     */
    public function getList($docId, $page, $rowsPerPage, $sort, $sortDir, $letter)
    {
        $query = $this->model->where('docid', $docId);

        $sortColumn = 'company';
        if ($sort == 'name') {
            $sortColumn = 'lastname';
        }

        if (!empty($letter)) {
            $query = $query->where('company', 'like', $letter . '%');
        }

        $totalNumber = $query->count();

        $resultQuery = $query->orderBy($sortColumn, $sortDir)
            ->skip($page * $rowsPerPage)
            ->take($rowsPerPage);

        return [
            'total'  => $totalNumber,
            'result' => $resultQuery->get(),
        ];
    }

    /**
     * @param int $sleeplabId
     * @param array $data
     * @return bool|int
     */
    public function updateSleeplab($sleeplabId, array $data)
    {
        return $this->model->where('sleeplabid', $sleeplabId)->update($data);
    }
}
