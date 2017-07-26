<?php

namespace DentalSleepSolutions\Structs;

class PdfMarginData
{
    const DEFAULT_TOP = 27;
    const DEFAULT_LEFT = 15;
    const DEFAULT_RIGHT = 15;
    const DEFAULT_BOTTOM = 25;
    const DEFAULT_HEADER = 5;
    const DEFAULT_FOOTER = 10;

    /** @var int */
    public $top = self::DEFAULT_TOP;

    /** @var int */
    public $left = self::DEFAULT_LEFT;

    /** @var int */
    public $right = self::DEFAULT_RIGHT;

    /** @var int */
    public $bottom = self::DEFAULT_BOTTOM;

    /** @var int */
    public $header = self::DEFAULT_HEADER;

    /** @var int */
    public $footer = self::DEFAULT_FOOTER;
}
