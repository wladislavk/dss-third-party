<?php

namespace DentalSleepSolutions\Structs;

use Illuminate\Contracts\Support\Arrayable;

class FinalRankData implements Arrayable
{
    /** @var int */
    public $lastSegment = 0;

    /** @var int */
    public $finalSegment = 0;

    /** @var int */
    public $finalRank = 0;

    /**
     * @return int[]
     */
    public function toArray(): array
    {
        return [
            'last_segment' => $this->lastSegment,
            'final_segment' => $this->finalSegment,
            'final_rank' => $this->finalRank,
        ];
    }
}
