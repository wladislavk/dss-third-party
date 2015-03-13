<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\HstInterface;
use Ds3\Eloquent\Hst;

class HstRepository implements HstInterface
{
    public function get($viewed, $status, $where)
    {
        $hst = Hst::whereRaw('(status IN (' . $status . '))')
            ->whereRaw('(viewed IS NULL or viewed != ' . $viewed . ')');

        foreach ($where as $key => $value) {
            $hst = $hst->where($key, '=', $value);
        }                      

        return $hst->get();
    }
}
