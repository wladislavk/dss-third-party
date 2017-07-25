<?php

namespace DentalSleepSolutions\Structs;

use Illuminate\Contracts\Support\Arrayable;

class PdfData implements Arrayable
{
    /** @var PdfHeaderData */
    public $headerData;

    /** @var PdfFontData */
    public $fontData;

    /** @var PdfMarginData */
    public $marginData;

    /** @var array */
    public $content = [];

    public function __construct()
    {
        $this->fontData = new PdfFontData();
        $this->headerData = new PdfHeaderData();
        $this->marginData = new PdfMarginData();
    }

    public function toArray()
    {
        return [
            'header_info' => [
                'title' => $this->headerData->title,
                'subject' => $this->headerData->subject,
                'keywords' => $this->headerData->keywords,
                'author' => $this->headerData->author,
            ],
            'font' => [
                'family' => $this->fontData->family,
                'size' => $this->fontData->size,
            ],
            'margins' => [
                'top' => $this->marginData->top,
                'left' => $this->marginData->left,
                'right' => $this->marginData->right,
                'bottom' => $this->marginData->bottom,
                'header' => $this->marginData->header,
                'footer' => $this->marginData->footer,
            ],
            'content' => $this->content,
        ];
    }
}
