<?php

namespace DentalSleepSolutions\Structs;

class PdfFontData
{
    const DEFAULT_FAMILY = 'Helvetica';
    const DEFAULT_SIZE = 10;

    /** @var string */
    public $family = self::DEFAULT_FAMILY;

    /** @var int */
    public $size = self::DEFAULT_SIZE;
}
