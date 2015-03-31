<?php namespace Ds3\Repositories;

use Ds3\Contracts\MemoAdminInterface;
use Ds3\Eloquent\Memo\MemoAdmin;

class MemoAdminRepository implements MemoAdminInterface
{
    public function getActualMemoAdmins()
    {
        $memoAdmins = MemoAdmin::actual()->get();

        return $memoAdmins;
    }
}
