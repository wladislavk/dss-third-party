<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\InsDiagnosisInterface;
use Ds3\Eloquent\InsDiagnosis;

class InsDiagnosisRepository implements InsDiagnosisInterface
{
    public function getActiveInsDiagnosis()
    {
        $insDiagnosis = InsDiagnosis::active()
            ->orderBy('sortby')
            ->get();

        return $insDiagnosis;
    }
}
