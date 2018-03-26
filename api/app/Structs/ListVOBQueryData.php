<?php

namespace DentalSleepSolutions\Structs;

class ListVOBQueryData
{
    /** @var int */
    public $docId = 0;

    /** @var string */
    public $sortColumn = '';

    /** @var string */
    public $sortDir = 'asc';

    /** @var int */
    public $vobsPerPage = 0;

    /** @var int */
    public $offset = 0;

    /** @var bool|null */
    public $viewed;
}
