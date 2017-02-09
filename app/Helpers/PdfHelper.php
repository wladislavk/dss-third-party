<?php

namespace DentalSleepSolutions\Helpers;

use PDF;
use URL;

class PdfHelper
{
    const LETTER_PDF_FOLDER = 'letter_pdfs/';

    private $letterPdfPath;
    private $options;

    public function __construct()
    {
        $this->letterPdfPath = public_path() . '/' . self::LETTER_PDF_FOLDER;

        $this->options = [
            'title'     => 'Default Pdf Title',
            'subject'   => 'Default Pdf Subject',
            'keywords'  => 'DSS Correspondence',
            'author'    => 'Dental Sleep Solutions',
            'fax'       => null,
            'header'    => '',
            'footer'    => '',
            'cover'     => '',
            'doc_id'    => null,
            'letter_id' => null
        ];
    }

    public function setOptions($options)
    {
        $this->options = array_merge($this->options, $options);
    }

    public function create($template, $data, $filename)
    {
        $data = array_merge($this->options, $data);

        $pdf = PDF::loadView($template, $data)->save($this->letterPdfPath . $filename);

        return URL::to(self::LETTER_PDF_FOLDER . $filename);
    }
}
