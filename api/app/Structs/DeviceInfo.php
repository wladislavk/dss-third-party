<?php

namespace DentalSleepSolutions\Structs;

use Illuminate\Contracts\Support\Arrayable;

class DeviceInfo implements Arrayable
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var float
     */
    public $value;

    /**
     * @var string
     */
    public $imagePath;

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
