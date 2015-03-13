<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\InsDiagnosisInterface;
use Ds3\Eloquent\InsDiagnosis;

class InsDiagnosisRepository implements InsDiagnosisInterface
{
    public function get()
    {
        $insDiagnosis = InsDiagnosis::where('status', '=', 1)
            ->orderBy('sortby')
            ->get();

        return $insDiagnosis;
    }
}
