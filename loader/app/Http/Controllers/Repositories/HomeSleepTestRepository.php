<?php
namespace Ds3\Repositories;

use Illuminate\Support\Facades\DB;

use Ds3\Contracts\HomeSleepTestInterface;
use Ds3\Eloquent\Hst;

class HomeSleepTestRepository implements HomeSleepTestInterface
{
    public function getHomeSleepTests($viewed, $status, $where)
    {
        $hst = Hst::whereRaw('(status IN (' . $status . '))')
            ->whereRaw('(viewed IS NULL or viewed != ' . $viewed . ')');

        foreach ($where as $key => $value) {
            $hst = $hst->where($key, '=', $value);
        }

        return $hst->get();
    }
}
