<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Eloquent\Dental\Letter;
use PDF;
use URL;

class PdfHelper
{
    const LETTER_PDF_FOLDER = 'letter_pdfs/';

    private $user;
    private $letter;

    private $letterPdfPath;
    private $pdfData;
    private $args;

    public function __construct(User $user, Letter $letter)
    {
        $this->user = $user;
        $this->letter = $letter;

        $this->letterPdfPath = public_path() . '/' . self::LETTER_PDF_FOLDER;

        $this->pdfData = [
            'header_info' => [
                'title'     => 'Default Pdf Title',
                'subject'   => 'Default Pdf Subject',
                'keywords'  => 'DSS Correspondence',
                'author'    => 'Dental Sleep Solutions'
            ],
            'font' => [
                'family' => 'Helvetica',
                'size'   => 10
            ],
            'margins' => [
                'top'    => 27,
                'left'   => 15,
                'right'  => 15,
                'bottom' => 25,
                'header' => 5,
                'footer' => 10
            ],
            'content' => []
        ];

        $this->args = [
            'fax'       => null,
            'header'    => '',
            'footer'    => '',
            'cover'     => '',
            'doc_id'    => null,
            'letter_id' => null
        ];
    }

    public function setHeaderInfo($data)
    {
        $this->pdfData['header_info'] = array_merge($this->pdfData['header_info'], $data);
    }

    public function create($template, $content, $filename, $args = [])
    {
        $this->args = array_merge($this->args, $args);

        $margins = [];
        $font = [];
        if (!empty($this->args['doc_id'])) {
            $doctor = $this->user->find($this->args['doc_id']);

            if (!empty($doctor) && $doctor->user_type == 2) {
                $margins = [
                    'top'    => $doctor->letter_margin_top,
                    'left'   => $doctor->letter_margin_left,
                    'right'  => $doctor->letter_margin_right,
                    'bottom' => $doctor->letter_margin_bottom,
                    'header' => $doctor->letter_margin_header,
                    'footer' => $doctor->letter_margin_footer
                ];

                if (!empty($this->args['letter_id'])) {
                    $letter = $this->letter->find($this->args['letter_id']);

                    if (!empty($letter)) {
                        $font = [
                            'family' => $letter->font_family,
                            'size'   => $letter->font_size
                        ];
                    }
                }
            }
        }

        $this->pdfData['font'] = array_merge($this->pdfData['font'], $font);
        $this->pdfData['margins'] = array_merge($this->pdfData['margins'], $margins);
        $this->pdfData['content'] = array_merge($this->pdfData['content'], $content);

        $pdf = PDF::loadView($template, $this->pdfData)->save($this->letterPdfPath . $filename);

        return URL::to(self::LETTER_PDF_FOLDER . $filename);
    }
}
