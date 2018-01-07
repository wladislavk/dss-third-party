<?php

namespace DentalSleepSolutions\Structs;

use Illuminate\Contracts\Support\Arrayable;

class GuideSettingOption implements Arrayable
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string[]
     */
    public $labels;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $number;

    public function toArray()
    {
        return [
            'id' => $this->id,
            'labels' => $this->labels,
            'name' => $this->name,
            'number' => $this->number,
        ];
    }
}
