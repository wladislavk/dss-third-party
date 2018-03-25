<?php
namespace Ds3\Repositories;

use Ds3\Contracts\SupportCategoryInterface;
use Ds3\Eloquent\Support\SupportCategory;

class SupportCategoryRepository implements SupportCategoryInterface
{
    public function getNonActive()
    {
        $supportCategory = SupportCategory::nonActive()
            ->orderBy('title')
            ->get();

        return $supportCategory;
    }
}
