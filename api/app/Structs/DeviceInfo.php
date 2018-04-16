<?php

namespace DentalSleepSolutions\Structs;

use Illuminate\Contracts\Support\Arrayable;

class DeviceInfo implements Arrayable
{
    private const DEFAULT_CHECKED_RANGE_VALUE = 1;

    /**
     * @var int
     */
    public $id = 0;

    /**
     * @var int
     */
    public $impression = 0;

    /**
     * @var int
     */
    public $checkedRangeValue = self::DEFAULT_CHECKED_RANGE_VALUE;

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var float
     */
    public $value = 0.0;

    /**
     * @var string
     */
    public $imagePath = '';

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'value' => $this->value,
            'image_path' => $this->imagePath,
        ];
    }
}
