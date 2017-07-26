<?php

namespace DentalSleepSolutions\Structs;

class PdfHeaderData
{
    const DEFAULT_TITLE = 'Default Pdf Title';
    const DEFAULT_SUBJECT = 'Default Pdf Subject';
    const DEFAULT_KEYWORDS = 'DSS Correspondence';
    const DEFAULT_AUTHOR = 'Dental Sleep Solutions';

    /** @var string */
    public $title = self::DEFAULT_TITLE;

    /** @var string */
    public $subject = self::DEFAULT_SUBJECT;

    /** @var string */
    public $keywords = self::DEFAULT_KEYWORDS;

    /** @var string */
    public $author = self::DEFAULT_AUTHOR;
}
