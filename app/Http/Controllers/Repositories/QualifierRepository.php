<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\QualifierInterface;
use Ds3\Eloquent\Qualifier;

class QualifierRepository implements QualifierInterface
{
    public function getQualifiers()
    {
        $qualifiers = Qualifier::active()
            ->orderBy('sortby')
            ->get();

        return $qualifiers;
    }
}
