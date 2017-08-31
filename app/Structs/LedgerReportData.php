<?php

namespace DentalSleepSolutions\Structs;

class LedgerReportData
{
    /** @var int */
    public $docId = 0;

    /** @var int */
    public $patientId = 0;

    /** @var int */
    public $page = 0;

    /** @var int */
    public $rowsPerPage = 0;

    /** @var string */
    public $sort = '';

    /** @var string */
    public $sortDir = '';

    public function toArray()
    {
        return [
            'doc_id'        => $this->docId,
            'patient_id'    => $this->patientId,
            'page'          => $this->page,
            'rows_per_page' => $this->rowsPerPage,
            'sort'          => $this->sort,
            'sort_dir'      => $this->sortDir,
        ];
    }
}
