<?php

namespace DentalSleepSolutions\Wrappers\PDF;

interface PDFWrapperInterface
{
    /**
     * @param string $view
     * @param array $data
     * @param array $mergeData
     * @param string $encoding Not used yet
     * @return mixed
     */
    public function loadView($view, $data = [], $mergeData = [], $encoding = null);

    /**
     * @param string $filename
     * @return mixed
     */
    public function save($filename);
}
