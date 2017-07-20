<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;

class Sleeplab extends AbstractModel implements Resource
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['sleeplabid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_sleeplab';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'sleeplabid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function getList($docId, $page, $rowsPerPage, $sort, $sortDir = 'asc', $letter = '')
    {
        $query = $this->where('docid', $docId);

        switch ($sort) {
            case 'lab':
                $sortColumn = 'company';
                break;

            case 'name':
                $sortColumn = 'lastname';
                break;

            default:
                $sortColumn = 'company';
                break;
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
            'result' => $resultQuery->get()
        ];
    }

    public function updateSleeplab($sleeplabId, $data = [])
    {
        return $this->where('sleeplabid', $sleeplabId)
            ->update($data);
    }
}
