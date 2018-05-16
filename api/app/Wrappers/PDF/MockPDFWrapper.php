<?php

namespace DentalSleepSolutions\Wrappers\PDF;

// temporary class, remove it once saving to container is implemented
class MockPDFWrapper implements PDFWrapperInterface
{
    public function loadView($view, $data = [], $mergeData = [], $encoding = null)
    {
        // do nothing
    }

    public function save($filename)
    {
        // do nothing
    }
}
