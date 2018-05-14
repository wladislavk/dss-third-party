<?php

namespace DentalSleepSolutions\Wrappers\PDF;

use Barryvdh\DomPDF\PDF;

class DomPDFWrapper implements PDFWrapperInterface
{
    /** @var PDF */
    private $domPdf;

    public function __construct(PDF $domPdf)
    {
        $this->domPdf = $domPdf;
    }

    /**
     * @param string $view
     * @param array $data
     * @param array $mergeData
     * @param string $encoding Not used yet
     * @return PDF
     */
    public function loadView($view, $data = [], $mergeData = [], $encoding = null)
    {
        return $this->domPdf->loadView($view, $data, $mergeData, $encoding);
    }

    /**
     * @param string $filename
     * @return PDF
     */
    public function save($filename)
    {
        return $this->domPdf->save($filename);
    }
}
